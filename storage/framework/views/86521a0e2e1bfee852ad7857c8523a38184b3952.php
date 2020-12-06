<?php $__env->startSection('content'); ?>

    <div class="row d-flex  h-100 justify-content-center align-items-center">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('loginsubmit')); ?>" method="post">

                        <div class="form-group">
                            <h1 class="h4">Iniciar sesión</h1>
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" name="usuario" class="form-control" value="<?php echo e(old('usuario')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Clave</label>
                            <input type="password" name="clave" class="form-control" value="<?php echo e(old('clave')); ?>">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/login.blade.php ENDPATH**/ ?>