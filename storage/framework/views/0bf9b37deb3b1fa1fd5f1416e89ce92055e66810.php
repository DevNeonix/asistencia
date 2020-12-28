<?php $__env->startSection('content'); ?>
    <h1 class="h4">Listado de Asistencias</h1>
    <form>

        <div class="form-inline">
            <div class="form-group mx-1">
                <input type="date" id="f1" name="fechaini" class="form-control txtdate" value="<?php echo e(request("fechaini")); ?>">
            </div>
            <div class="form-group mx-1">
                <input type="date" id="f2" name="fechafin" class="form-control txtdate" value="<?php echo e(request("fechafin")); ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
        </div>
    </form>
    <a href="<?php echo e(route('admin.reporte.asistenciadia.export')); ?>" class="btn btn-primary btn-sm m-0 p-0">Exportar</a>
    <table class="table table-sm table-hover" style="font-size: 10px">
        <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>OT</th>
            <th>Descripcion</th>
            <th>Fecha</th>
            <th>Asistencias Ingresadas por día</th>
            <th colspan="11">Asistencias</th>
            <th>Resumen en Minutos</th>
            <th>Resumen en Horas</th>
        </tr>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->nombre); ?></td>
                <td><?php echo e($item->doc_ide); ?></td>
                <td><?php echo e($item->nro_orden); ?></td>
                <td><?php echo e($item->producto_fabricar); ?></td>
                <td><?php echo e(substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)); ?></td>
                <td class="text-right"><?php echo e($item->cantidad_marcaciones); ?></td>

                <?php
                $asistencias = \App\Models\Marcacion::where('personal', $item->id_personal)
                    ->where('orden_trabajo', $item->id_ot)
                    ->whereYear('fecha', $item->ano)
                    ->whereMonth('fecha', $item->mes)
                    ->whereDay('fecha', $item->dia)
                    ->get();
                $cnt = 1;
                ?>

                <?php $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td>
                        <p style="font-size: 10px" class="p-0 m-0"><?php echo e($asistencia->fecha); ?></p>
                        <?php
                        $responsable = \App\Models\User::where('id', $asistencia->usuario_registra)->first();
                        ?>
                        <?php if($responsable != null): ?>
                            <p style="font-size: 10px" class="p-0 m-0 text-muted"><?php echo e($responsable->name); ?></p>
                        <?php endif; ?>
                    </td>
                    <?php
                    $cnt = $cnt + 1;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($item->cantidad_marcaciones%2 ==1): ?>
                    <td><input type="datetime-local" min="<?php echo e(substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)); ?>T00:00" value="<?php echo e($item->ano); ?>-<?php echo e(substr("00".$item->mes,-2)); ?>-<?php echo e($item->dia); ?>T00:00"></td>
                    <td></td>
                <?php endif; ?>

                <?php for($cnt=$cnt;$cnt<=11;$cnt++): ?>
                    <td></td>
                <?php endfor; ?>
                <?php if($item->cantidad_marcaciones % 2 == 0): ?>
                    <?php for($x=0;$x<$item->cantidad_marcaciones/2;$x++): ?>
                        <td><?php echo e(\Illuminate\Support\Carbon::parse($asistencias[$x]->fecha)->diffInMinutes($asistencias[$x+1]->fecha)); ?></td>

                        <?php
                        $x++
                        ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/tareo/index.blade.php ENDPATH**/ ?>