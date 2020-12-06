
<?php

    $a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
    $b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
    $dates = [];
    for ($a;$a<=$b;){
        array_push($dates,$a->format('Y-m-d'));
        $a->addDay();
    }
?>

<table class="table my-2 table-responsive">
    <thead>
    <tr>
        <th colspan=2>Personal</th>
        <th colspan="<?php echo e(count($dates)); ?>">Días</th>
        <th>Horas Trabajadas</th>
        <th colspan="3">Horas Extras</th>
    </tr>
    <tr>
        <td colspan=2></td>
        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($d); ?></td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <td></td>
        <td>Tot extras</td>
        <td>25%</td>
        <td>35%</td>
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
            <td><a href="<?php echo e(route('admin.personal.edit',$i->id)); ?>"><?php echo e($i->apellidos); ?>, <?php echo e($i->nombres); ?></a>
            </td>

            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($x = \App\Models\Marcacion::where('personal',$i->id)->where('fechaymd',$d)->get()); ?>
                <td>
                    <?php ($trabajadas = ($x->count() == 0)?$trabajadas:$trabajadas+8); ?>
                    <?php ($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8); ?>
                    <?php ($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8); ?>
                    <strong><?php echo e(($x->count() == 0)?0:8); ?></strong> horas trabajadas
                    <br>
                    <?php ($extra = 0); ?>
                    <?php $__currentLoopData = $x; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($extra = $extra + ($j->minutos_extra / 60)); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php ($extras = $extras + $extra); ?>
                    <strong><?php echo e($extra); ?></strong> horas extra
                    <br>
                    <strong><?php echo e($x->count()); ?></strong> Ot(s) asistida(s)
		    <br>
			<br>
                        <?php $__currentLoopData = $x; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($o->ot->nro_orden); ?> <?php echo e($o->ot->producto_fabricar); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    <?php
                    if ($extra <= 2) {
                        $extras25 = $extras25 + $extra;
                    } else {
                        $extras25 = $extras25 + 2;
                        $extras35 = $extras35 + ($extra - 2);
                    }

                    ?>

                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($trabajadas); ?></td>
            <td><?php echo e($extras); ?></td>
            <td><?php echo e($extras25); ?></td>
            <td><?php echo e($extras35); ?></td>


        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>

</table>
<?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/asistencia-personal-excel.blade.php ENDPATH**/ ?>