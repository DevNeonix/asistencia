<h1 class="h4">Listado de Asistencias</h1>
<table class="table table-sm table-hover" style="font-size: 10px">
    <tr>
        <th>Nombre</th>
        <th>DNI</th>
        <th>OT</th>
        <th>Descripcion</th>
        <th>Fecha</th>
        <th># Asistencias</th>
        <th colspan="11">Asistencias</th>
        <th>Resumen en Minutos</th>
        <th>Resumen en Horas</th>
    </tr>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td width="50"><?php echo e($item->nombre); ?></td>
            <td width="20">&nbsp;<?php echo e($item->doc_ide); ?></td>
            <td width="20">&nbsp;<?php echo e($item->nro_orden); ?></td>
            <td width="50"><?php echo e($item->producto_fabricar); ?></td>
            <td width="20"><?php echo e(substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)); ?></td>
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
                <td width="40">
                    <p style="font-size: 10px" class="p-0 m-0"><?php echo e($asistencia->fecha); ?></p>
                    <?php
                    $responsable = \App\Models\User::where('id', $asistencia->usuario_registra)->first();
                    ?>
                    <?php if($responsable != null): ?>
                        <p style="font-size: 10px" class="p-0 m-0 text-muted">&nbsp;<?php echo e($responsable->name); ?></p>
                    <?php endif; ?>
                </td>
                <?php
                $cnt = $cnt + 1;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($item->cantidad_marcaciones%2 ==1): ?>
                <td width="40" style="background-color: #ff6347">NO REGISTRADA</td>
                <td></td>
            <?php endif; ?>

            <?php for($cnt=$cnt;$cnt<=11;$cnt++): ?>
                <td></td>
            <?php endfor; ?>
            <?php if($item->cantidad_marcaciones % 2 == 0): ?>
                <?php for($x=0;$x<$item->cantidad_marcaciones/2;$x++): ?>
                    <?php
                    $min = \Illuminate\Support\Carbon::parse($asistencias[$x]->fecha)->diffInMinutes($asistencias[$x + 1]->fecha);
                    ?>
                    <td><?php echo e($min); ?></td>
                    <td><?php echo e(round($min/60,2)); ?></td>

                    <?php
                    $x++
                    ?>
                <?php endfor; ?>
            <?php endif; ?>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php /**PATH /var/www/html/asistencia/resources/views/pages/exports/marcacion-dia.blade.php ENDPATH**/ ?>