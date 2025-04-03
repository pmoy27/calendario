<?php $__env->startSection('body-attribuet'); ?>
class="authentication-bg"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="account-pages py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <div class="mx-auto mb-4 text-center auth-logo">
                                <a href="<?php echo e(route('any', 'index')); ?>" class="logo-dark">
                                    <img src="/images/logomunihazul.png" height="60" alt="logo dark">
                                </a>

                                <a href="<?php echo e(route('any', 'index')); ?>" class="logo-light">
                                    <img src="/images/logomunihblanco.png" height="60" alt="logo light">
                                </a>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Agenda Psicotécnico!</h3>

                        </div>
                        <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-4">

                            <?php echo csrf_field(); ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electronico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="ingrese su correo electronico">
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label">Contraseña</label>

                                </div>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="ingrese su contraseña">
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-dark btn-lg fw-medium" type="submit">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', ['subtitle' => 'Sign In'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/pablooyarzo/Desktop/Proyectos/agenda/resources/views/auth/signin.blade.php ENDPATH**/ ?>