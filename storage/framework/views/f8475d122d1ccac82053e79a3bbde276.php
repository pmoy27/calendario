<div class="app-sidebar">
     <!-- Sidebar Logo -->
     <div class="logo-box">
          <a href="<?php echo e(route('any', 'index')); ?>" class="logo-dark">
               <img src="/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="/images/logo-dark.png" class="logo-lg" alt="logo dark">
          </a>

          <a href="<?php echo e(route('any', 'index')); ?>" class="logo-light">
               <img src="/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="/images/logo-light.png" class="logo-lg" alt="logo light">
          </a>
     </div>

     <div class="scrollbar" data-simplebar>

          <ul class="navbar-nav" id="navbar-nav">

               <li class="menu-title">Menu...</li>

               <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('any', 'index')); ?>">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:widget-2-outline"></iconify-icon>
                         </span>
                         <span class="nav-text"> Dashboard </span>
                         <span class="badge bg-primary badge-pill text-end">New</span>
                    </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('any', 'calendario')); ?>">
                         <span class="nav-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);"><path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path></svg>
                              
                         </span>
                         <span class="nav-text"> Calendario </span>
                      
                    </a>
               </li>


              

           
          </ul>
     </div>
</div><?php /**PATH C:\Users\PC-INFORMATICA 2\Desktop\laravel\Agenda\resources\views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>