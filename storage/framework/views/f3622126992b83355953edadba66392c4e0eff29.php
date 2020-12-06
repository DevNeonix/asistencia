<?php $__env->startSection('content'); ?>
    <h1 class="h4">Listado de personal</h1>
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
            <div class="form-group">
                <a class="btn btn-sm btn-primary text-white" href="<?php echo e(route('admin.user.create')); ?>">Nuevo</a>
            </div>
        </div>
    </div>

    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="<?php echo e($i->estado==0?'text-muted':''); ?>">
                <td><?php echo e($i->id); ?></td>
                <td><?php echo e($i->name); ?></td>
                <td><?php echo e($i->email); ?></td>
                <td>
                    <?php
                    $roles = DB::table('rol_empleado')->where('id', $i->tipo)->get();
                    ?>

                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($rol->detalle); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </td>
                <td>
                    <?php echo e($i->estado == 1?'Activo':'Eliminado'); ?>

                </td>
                <td>

                    <a href="<?php echo e(route('admin.user.edit',$i->id)); ?>" class="btn btn-success btn-sm">Editar</a>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
    <?php echo e($data->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/users.blade.php ENDPATH**/ ?>