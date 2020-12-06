<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 ">
            <h5>Marcacion para el Producto <b><?php echo e($ot->producto_fabricar); ?></b> del cliente <b><?php echo e($ot->cliente); ?></b>
            </h5>
        </div>

        <?php

        $empleados = DB::table('view_orden_trabajo_personal')->where('id_ot', $ot->id)->get();

        ?>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <?php
                    $k = 0
                    ?>
                    <td>
                        <?php echo e($i->nombre); ?>

                        <?php
                        $x = DB::select(DB::raw("select * from marcacion where orden_trabajo='" . $ot->id . "' and personal = " . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) "));
                        ?>
                        <?php $__currentLoopData = $x; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p class="text-muted text-italic">

                                <?php
                                $k = $k + 1;
                                ?>
                                <b><?php echo e($k%2==0?"Salió":'Ingresó'); ?></b>: <?php echo e(\Carbon\Carbon::parse($j->fecha)->diffForHumans(\Carbon\Carbon::now())); ?>


                            </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($k==0): ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-block">
                                        <form action="<?php echo e(route('admin.marcacion.faltas.registro')); ?>" type="post">

                                            <div class="form-group">
                                                <label>Desde</label>
                                                <input type="date" class="form-control form-control-sm mydate"
                                                       name="desde"
                                                       value="<?php echo e(date('y')."-".date('m').'-'.date('d')); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Hasta</label>
                                                <input type="date" class="form-control form-control-sm mydate"
                                                       name="hasta"
                                                       value="<?php echo e(date('y')."-".date('m').'-'.date('d')); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Motivo</label>
                                                <input type="hidden" name="personal" value="<?php echo e($i->id_personal); ?>">
                                                <input type="hidden" name="ot" value="<?php echo e($i->id_ot); ?>">

                                                <select name="falta" class="form-control">
                                                    <option value="1">Vacaciones</option>
                                                    <option value="2">Permiso</option>
                                                    <option value="3">Falta injustificada</option>
                                                    <option value="4">Licencia médica</option>

                                                </select>
                                            </div>
                                            <button class="btn btn-danger btn-sm" type="submit">Registrar Falta
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-italic">No se puede registrar una falta si ya ha ingresado.</p>
                        <?php endif; ?>
                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
        $('.mydate').val(today);
        $('.mydate').prop("min", today);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/marcacion_faltas.blade.php ENDPATH**/ ?>