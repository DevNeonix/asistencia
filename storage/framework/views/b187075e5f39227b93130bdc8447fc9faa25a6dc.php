<?php $__env->startSection('content'); ?>
    <h1 class="h4">Listado de personal por OT'S</h1>
    <div class="col-12 col-md-4">
        <form>
            <div class="form-group form-inline">
                <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar"
                       value="<?php echo e(request('buscar')); ?>">
                <button type="submit" class="btn btn-primary btn-sm mx-1">Buscar</button>
            </div>
        </form>
    </div>
    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nro Orden</th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($i->id); ?></td>
                <td><?php echo e($i->nro_orden); ?></td>
                <td><?php echo e($i->producto_fabricar); ?></td>
                <td><?php echo e($i->cliente); ?></td>
                <td><?php echo e($i->estado == 1 ? 'Activo':'Finalizado'); ?></td>
                <td>
                    <a class="btn btn-sm btn-success" href="<?php echo e(route('admin.ots_personal.edit',$i->id)); ?>">Editar
                        Personal</a>
                </td>
            </tr>
            <tr style="border-top: none">
                <td style="border-top: none">
                    <b>Personal: </b>
                    <ul>
                        <?php
                        $personal = \Illuminate\Support\Facades\DB::table('view_orden_trabajo_personal')->where('id_ot', $i->id)->orderBy('nombre')->get();
                        ?>

                        <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($p->nombre); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
    <?php echo e($data->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/ots_personal.blade.php ENDPATH**/ ?>