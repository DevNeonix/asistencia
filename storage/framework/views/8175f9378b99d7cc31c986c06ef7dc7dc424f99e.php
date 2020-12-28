<?php $__env->startSection('content'); ?>
    <h1 class="h4">Listado de Centros de costo</h1>
    <div class="row">
        <div class="col-12 col-md-4">
            <form>
                <div class="form-group form-inline">
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar"
                           value="<?php echo e(request('buscar')); ?>">
                    <button type="submit" class="btn btn-primary btn-sm mx-1">Buscar</button>
                </div>
            </form>
        </div>
        <div class="col-12">
            <a href="<?php echo e(route('admin.cc.create')); ?>" class="m-2 btn btn-primary btn-sm">Nuevo</a>
        </div>
    </div>
    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr class="row">
            <th class="col-md-1">Id</th>
            <th class="col-md-2">Codigo</th>
            <th class="col-md-3" style="width: 150px">Detalle</th>
            <th class="col-md-3">Ubicacion</th>
            <th class="col-md-3">Acciones</th>

        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="row">
                <td class="col-md-1"><?php echo e($i->id); ?></td>
                <td class="col-md-2"><?php echo e($i->codigo); ?></td>
                <td class="col-md-3"><?php echo e($i->detalle); ?></td>
                <td class="col-md-3"><?php echo e($i->ubicacion); ?></td>

                <td class="col-md-3">

                    <a href="<?php echo e(route('admin.cc.edit',$i->id)); ?>" class="btn btn-success btn-sm">Editar</a>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
    <?php echo e($data->links()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        // $("table").addClass('the-table');

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/centrocosto/index.blade.php ENDPATH**/ ?>