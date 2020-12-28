<table class="table table-sm table-responsive">
    <tr style="background-color: #f3aeae">
        <th width="50">Tareado Por</th>
        <th width="50">Apellidos y nombres</th>
        <th width="20">DNI</th>
        <th width="20">CC</th>
        <th width="20">Centro de Costo</th>
        <th width="15">Ubicación</th>
        <th width="15">OT</th>
        <th width="50">Descripción</th>
        <th width="20">Cliente</th>
        <th width="20">Fecha</th>
        <th>Horas Normales</th>
        <th>Licencia Goce de Haber</th>
        <th>Licencia sin Goce de Haber</th>
        <th>Horas Extras</th>
        <th>Hrs 25%</th>
        <th>Hrs 35%</th>
        <th>Domingos/Feriados</th>
        <th>Faltas</th>
        <th>Vacaciones</th>
        <th>Dias de Descanzo medico</th>
        <th>Permiso</th>
        <th>Viatico</th>
        <th>Observación</th>
    </tr>
    <?php
        $today = today();
        $dates = [];

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('y-m-d');
        }
    ?>
    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $marcas = \App\Models\VMarcacionDia::where('fechaymd',$date)->orderBy('nombre')->get()

        ?>
        <?php if($marcas->count()>0): ?>
            <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                    <td><?php echo e($marca->tareadopor); ?></td>
                    <td><?php echo e($marca->nombre); ?></td>
                    <td><?php echo e($marca->doc_ide); ?></td>
                    <?php
                        $cc = \App\Models\CentroCosto::find($marca->centro_costo_id);
                        $ot = \App\Models\OrdenTrabajo::find($marca->id_ot)
                    ?>
                    <td><?php echo e($cc->codigo??null); ?></td>
                    <td><?php echo e($cc->detalle??null); ?></td>
                    <td><?php echo e($marca->ot_ubicacion??null); ?></td>

                    <td><?php echo e($marca->nro_orden); ?></td>
                    <td><?php echo e($marca->producto_fabricar); ?></td>
                    <td><?php echo e($marca->cliente); ?></td>
                    <td><?php echo e($date); ?></td>
                    
                    
                    <?php
                        $nroMarcasPordia = \App\Models\Marcacion::where('orden_trabajo',$marca->id_ot)->where('personal',$marca->id_personal)->where('fechaymd',$marca->fechaymd)->distinct()->get('orden_trabajo','fechaymd')->count();
                    ?>
                    <td><?php echo e(8/$nroMarcasPordia); ?></td>
                    

                    <td></td>
                    <td></td>
                    <?php
                        $hextra= round($marca->minutos_extras/60,2);
                        if ($hextra < 2){
                            $hextra25= $hextra;
                            $hextra35= 0;
                        }
                        if ($hextra >= 2){
                            $hextra25= 2;
                            $hextra35= $hextra-2;
                        }


                    ?>
                    <td><?php echo e($hextra); ?></td>
                    <td><?php echo e($hextra25); ?></td>
                    <td><?php echo e($hextra35); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo e($ot->viatico); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>

            <tr style="background-color: #66ff00;">
                <td colspan="9" style="text-align: center">
                    <h5><?php echo e(\Illuminate\Support\Str::upper(\Illuminate\Support\Carbon::make($date)->locale('es_ES')->dayName)); ?></h5>
                </td>
                <td><?php echo e($date); ?></td>
                <td></td>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
<?php /**PATH /var/www/html/asistencia/resources/views/pages/exports/tareo.blade.php ENDPATH**/ ?>