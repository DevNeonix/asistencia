<?php

    $a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
    $b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
    $dates = [];
    for ($a;$a<=$b;){
        array_push($dates,$a->format('Y-m-d'));
        $a->addDay();
    }
?>

<table class="table my-2 table-responsive" style="max-height: 50vh">
    <thead>
    <tr>
        <th colspan="2">Personal</th>
        <th>Horas Trabajadas</th>
        <td></td>
        <th colspan="3">Horas Extras</th>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Días trabajados</td>
        <td>Tot horas trabajadas</td>
        <td>Tot extras</td>
        <td>25%</td>
        <td>35%</td>
        <td colspan="30" class="text-center">Ots</td>
    </tr>
    </thead>

    <tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $extras = 0;
            $extras25 = 0;
            $extras35 = 0;
            $extras100 = 0;
            $trabajadas = 0;

        ?>
        <tr>
            <td><?php echo e($i->doc_ide); ?></td>
            <td><?php echo e($i->id); ?> <a href="<?php echo e(route('admin.personal.edit',$i->id)); ?>"><?php echo e($i->apellidos); ?>, <?php echo e($i->nombres); ?></a>
            </td>

            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($x = \App\Models\Marcacion::where('personal',$i->id)->where('fechaymd',$d)->get()); ?>
                <?php ($f = \App\Models\Falta::where('personal',$i->id)->where('fecha',$d)->get()); ?>
                <?php ($trabajadas = ($x->count() == 0)?$trabajadas:$trabajadas+8); ?>
                <?php ($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8); ?>
                <?php ($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8); ?>
                <?php ($extra = 0); ?>
                <?php $__currentLoopData = $x; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($extra = $extra + ($j->minutos_extra / 60)); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php ($extras = $extras + $extra); ?>
                <?php
                if ($extra <= 2) {
                    $extras25 = $extras25 + $extra;
                } else {
                    $extras25 = $extras25 + 2;
                    $extras35 = $extras35 + ($extra - 2);
                }
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <td><?php echo e($trabajadas/8); ?></td>
            <td><?php echo e($trabajadas); ?></td>
            <td><?php echo e($extras); ?></td>
            <td><?php echo e($extras25); ?></td>
            <td><?php echo e($extras35); ?></td>
            <?php ($ots=\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT personal,orden_trabajo,count(*) FROM marcacion where personal=".$i->id." and fecha between '".\Illuminate\Support\Carbon::createFromDate(request('f1'))."' and '".\Illuminate\Support\Carbon::createFromDate(request('f2'))."' group by personal,orden_trabajo"))); ?>
            <?php $__currentLoopData = $ots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td>
                    <?php ($o=\App\Models\OrdenTrabajo::find($ot->orden_trabajo)); ?>
                    <?php echo e($o->nro_orden); ?>-<?php echo e($o->producto_fabricar); ?>-<?php echo e($o->cliente); ?>

                </td>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>

</table>
<?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/asistencia-personal-resumen-excel.blade.php ENDPATH**/ ?>