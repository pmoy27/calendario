

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layouts.partials.page-title', ['title' => 'Agenda', 'subtitle' => 'Calendario'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;

    }
    .fc .fc-scrollgrid-liquid {
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
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',  locale: 'es',selectable: true, themeSystem: 'bootstrap5',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },  
            events: [
    { // this object will be "parsed" into an Event Object
      title: 'The Title', // a property!
      start: '2025-03-01', // a property!
      end: '2025-03-02' // a property! ** see important note below about 'end' **
    }
  ]
            
        })
        
        calendar.render()
      })

    </script>
<div class="row">

<div id='calendar'></div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/pages/dashboard.js']); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Calendario'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC-INFORMATICA 2\Desktop\laravel\Agenda\resources\views/calendario.blade.php ENDPATH**/ ?>