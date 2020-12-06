<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <?php $ottt = 0 ?>
                    <?php $__currentLoopData = $ot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        Nro Orden: <b><?php echo e($o->nro_orden); ?></b><br>
                        Producto: <b><?php echo e($o->producto_fabricar); ?></b><br>
                        Cliente: <b><?php echo e($o->cliente); ?></b>
                        <?php $ottt = $o->id?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <br>
                    <h6>Asignados</h6>
                    <table>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i->nombre); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.ots_personal.delete')); ?>" method="get">
                                        <input type="hidden" name="personal" value="<?php echo e($i->id_personal); ?>">
                                        <input type="hidden" name="ot" value="<?php echo e($ottt); ?>">
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>

                    <hr>
                    <h6>Disponibles</h6>
                    <?php
                    $disponibles = DB::select(DB::raw("SELECT * FROM personal where id not in (select id_personal from `view_orden_trabajo_personal` where id_ot=" . $ottt . ") order by apellidos"));
                    ?>
                    <table>

                        <?php $__currentLoopData = $disponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i->apellidos); ?> <?php echo e($i->nombres); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.ots_personal.store')); ?>" method="get">
                                        <input type="hidden" name="personal" value="<?php echo e($i->id); ?>">
                                        <input type="hidden" name="ot" value="<?php echo e($ottt); ?>">
                                        <button class="btn btn-success btn-sm">Agregar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/ots_personal_edit.blade.php ENDPATH**/ ?>