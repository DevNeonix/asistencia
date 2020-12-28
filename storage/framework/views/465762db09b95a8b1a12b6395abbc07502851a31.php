<?php $__env->startSection('content'); ?>
    <h1 class="h4">Edicion de Centro de costo</h1>
    <div class="row">
        <div class="col-12 col-md-5">
            <form action="<?php echo e(route('admin.cc.update',$centroCosto->id)); ?>" method="post">
                <?php echo method_field('put'); ?>
                <input type="hidden" class="form-control" name="id" value="<?php echo e($centroCosto->id); ?>">
                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" name="codigo" value="<?php echo e($centroCosto->codigo); ?>">
                </div>
                <div class="form-group">
                    <label>Detalle</label>
                    <input type="text" class="form-control" name="detalle" value="<?php echo e($centroCosto->detalle); ?>">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" name="area" value="<?php echo e($centroCosto->area); ?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Editar</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        // $("table").addClass('the-table');

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/centrocosto/edit.blade.php ENDPATH**/ ?>