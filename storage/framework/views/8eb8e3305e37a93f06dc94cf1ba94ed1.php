

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layouts.partials.page-title', ['title' => 'Agenda', 'subtitle' => 'Agenda'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
  #calendar {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;

  }

  .fc .fc-scrollgrid-liquid,
  .fc-listWeek-view {
    background-color: white;
  }

  .fc-daygrid-event {
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    padding: 5px;
  }

  .fc-daygrid-event:hover {
    background-color: #0056b3;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const fechaInput = document.getElementById('edit_fecha');
    const horaSelect = document.getElementById('edit_hora');

    if (!fechaInput || !horaSelect) {
      console.error("No se encontraron los elementos necesarios");
      return;
    }

    // Crear array de eventos directamente desde Blade
    const eventosCalendario = JSON.parse(`<?php echo json_encode($event->map(function($evento) {
        return [
            'id' => $evento->id,
            'title' => $evento->titulo.' - '.$evento->nombre.' - Fono: '.$evento->telefono,
            'start' => $evento->fecha_inicio,
            'end' => $evento->fecha_inicio,
            'extendedProps' => [
                'titulo' => $evento->titulo,
                'telefono' => $evento->telefono,
                'nombre' => $evento->nombre,
                'tipo_atencion' => $evento->id, // ID del tipo de atención
                'hora_inicio' => $evento->hora_inicio
            ]
        ];
    })); ?>`);

    const horarios = [
      "08:30:00", "08:45:00", "09:00:00", "09:15:00", "09:30:00",
      "09:45:00", "10:00:00", "10:15:00", "10:30:00", "10:45:00",
      "11:00:00", "11:15:00", "11:30:00", "11:45:00", "12:00:00",
      "12:15:00", "12:30:00", "12:45:00"
    ];

    // Función para cargar horarios disponibles
    function cargarHorariosDisponibles(fecha, horaActual = null) {
      if (!fecha) {
        horaSelect.disabled = true;
        horaSelect.innerHTML = '<option value="">Seleccione una fecha primero</option>';
        return;
      }

      horaSelect.disabled = true;
      horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';

      console.log("Consultando disponibilidad para:", fecha);
      console.log("Hora actual:", horaActual);

      fetch(`/check-disponibilidad?fecha=${fecha}`)
        .then(response => {
          console.log("Status de respuesta:", response.status);
          return response.json();
        })
        .then(data => {
          console.log("Datos recibidos:", data);

          horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';

          horarios.forEach(hora => {
            const formattedHora = hora.substring(0, 5);
            const option = document.createElement('option');
            option.value = hora; // Valor correcto: la hora completa
            option.textContent = formattedHora;

            // Verificar si el horario está ocupado, pero excluir el horario actual del evento
            const esHorarioActual = horaActual && hora === horaActual;
            const estaOcupado = data.horariosOcupados && data.horariosOcupados.includes(hora);

            if (estaOcupado && !esHorarioActual) {
              option.disabled = true;
              option.textContent = formattedHora + ' (No disponible)';
            }

            // Seleccionar la hora actual del evento
            if (esHorarioActual) {
              option.selected = true;
            }

            horaSelect.appendChild(option);
          });

          horaSelect.disabled = false;
        })
        .catch(error => {
          console.error('Error:', error);
          horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
        });
    }

    // Event listener para cambios en la fecha
    fechaInput.addEventListener('change', function() {
      cargarHorariosDisponibles(this.value);
    });

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listWeek',
      locale: 'es',
      selectable: true,
      themeSystem: 'bootstrap5',
      headerToolbar: {
        left: 'prev,next, today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Lista'
      },
      dayMaxEventRows: true, // for all non-TimeGrid views
      views: {
        timeGrid: {
          dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
        }
      },
      eventClick: function(info) {
        info.jsEvent.preventDefault();

        var evento = info.event;
        const props = evento.extendedProps;

        console.log("Evento completo:", evento);
        console.log("Propiedades extendidas:", props);

        // Rellenar formulario de edición
        document.getElementById('edit_id').value = evento.id;
        document.getElementById('edit_titulo').value = props.titulo;
        document.getElementById('edit_telefono').value = props.telefono;

        // Establecer el tipo de atención
        const selectTipo = document.getElementById('edit_tipo_atencion');
        if (props.tipo_atencion) {
          selectTipo.value = props.tipo_atencion;
        } else {
          selectTipo.selectedIndex = 0;
        }

        // Establecer la fecha y cargar horarios
        if (evento.start) {
          const fecha = evento.start.toISOString().substring(0, 10);
          document.getElementById('edit_fecha').value = fecha;

          // Llamar a la función para cargar horarios y seleccionar la hora actual
          cargarHorariosDisponibles(fecha, props.hora_inicio);
        }

        // Mostrar modal de edición
        const modal = new bootstrap.Modal(document.getElementById('editarEventoModal'));
        modal.show();
      },
      events: eventosCalendario
    });

    calendar.render();
  });
</script>
<div class="row">

  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Registrar en la Agenda</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo e(url('/events/create')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Agendar</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="simpleinput" class="form-label">Nombre Completo</label>
                <input type="text" name="titulo" id="simpleinput" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="simpleinput" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="simpleinput" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="tipo_atencion" class="form-label">Tipo de Atención</label>
                <select name="tipo_atencion" class="form-control" required>
                  <option selected>Seleccione una atención</option>
                  <?php $__currentLoopData = $tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option name="tipo_atencion" value="<?php echo e($tipos->id); ?>"><?php echo e($tipos->nombre); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="simpleinput" class="form-label">Fecha de la Reserva</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="hora" class="form-label">Hora de la Reserva</label>
                <select name="hora" id="hora" class="form-control" disabled required>
                  <option value="">Seleccione una fecha primero</option>
                </select>
              </div>
            </div>

            <div class="modal-footer">

              <button type="submit" class="btn btn-primary">Agendar</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>



  <div id='calendar'></div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');

    if (!fechaInput || !horaSelect) {
      console.error("No se encontraron los elementos necesarios");
      return;
    }


    const horarios = [
      "08:30:00", "08:45:00", "09:00:00", "09:15:00", "09:30:00",
      "09:45:00", "10:00:00", "10:15:00", "10:30:00", "10:45:00",
      "11:00:00", "11:15:00", "11:30:00", "11:45:00", "12:00:00",
      "12:15:00", "12:30:00", "12:45:00"
    ];


    fechaInput.addEventListener('change', function() {
      const fechaSeleccionada = this.value;

      if (!fechaSeleccionada) {

        horaSelect.disabled = true;
        horaSelect.innerHTML = '<option value="">Seleccione una fecha primero</option>';
        return;
      }


      horaSelect.disabled = true;
      horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';


      console.log("Consultando disponibilidad para:", fechaSeleccionada);

      fetch(`/check-disponibilidad?fecha=${fechaSeleccionada}`)
        .then(response => {
          console.log("Status de respuesta:", response.status);
          return response.json();
        })
        .then(data => {
          console.log("Datos recibidos:", data);


          horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';


          horarios.forEach(hora => {
            const formattedHora = hora.substring(0, 5);
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = formattedHora;


            if (data.horariosOcupados && data.horariosOcupados.includes(hora)) {
              option.disabled = true;
              option.textContent = formattedHora + ' (No disponible)';
            }

            horaSelect.appendChild(option);
          });


          horaSelect.disabled = false;
        })
        .catch(error => {
          console.error('Error:', error);
          horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
        });
    });
  });
</script>


<div class="modal fade" id="editarEventoModal" tabindex="-1" aria-labelledby="editarEventoModallLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo e(url('/events/create')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editarEventoModalLabel">Modifcar Agendar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="edit_id" id="edit_id" class="form-control" hidden>
          <div class="mb-3">
            <label for="simpleinput" class="form-label">Nombre Completo</label>
            <input type="text" name="edit_titulo" id="edit_titulo" class="form-control " required>
          </div>
          <div class="mb-3">
            <label for="simpleinput" class="form-label">Teléfono</label>
            <input type="text" name="edit_telefono" id="edit_telefono" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="tipo_atencion" class="form-label">Tipo de Atención</label>
            <select name="edit_tipo_atencion" id="edit_tipo_atencion" class="form-control" required>
              <option value="">Seleccione una atención</option>
              <?php $__currentLoopData = $tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($tipos->id); ?>"><?php echo e($tipos->nombre); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="simpleinput" class="form-label">Fecha de la Reserva</label>
            <input type="date" name="edit_fecha" id="edit_fecha" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="hora" class="form-label">Hora de la Reserva</label>
            <select name="edit_hora" id="edit_hora" class="form-control" disabled required>
              <option value="">Seleccione una fecha primero</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">

          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
    </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/pages/dashboard.js']); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Agenda'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/pablooyarzo/Desktop/Proyectos/agenda/resources/views/calendario.blade.php ENDPATH**/ ?>