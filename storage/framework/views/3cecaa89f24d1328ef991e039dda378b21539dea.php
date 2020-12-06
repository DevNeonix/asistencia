<?php $__env->startSection('content'); ?>
    <div class="col-12 ">
        <h5>Reporte de asistencia</b>
        </h5>
    </div>
    <form>

        <div class="form-inline row">
            <div class="form-group mx-1 col-md-3">
                <label for="f1">Fecha inicial</label>
                <input type="date" id="f1" name="f1" class="form-control txtdate" value="<?php echo e(request("f1")); ?>">
            </div>
            <div class="form-group mx-1 col-md-3">
                <label for="f2">Fecha final</label>
                <input type="date" id="f2" name="f2" class="form-control txtdate" value="<?php echo e(request("f2")); ?>">
            </div>
            <div class="form-group mx-1 col-md-3">
                <label for="orden">Ordenar por:</label>
                <select name="orden" id="orden" class="form-control">
                    <option value="fecha" <?php if(request('orden') == 'fecha'): ?> selected <?php endif; ?>>Fecha</option>
                    <option value="nro_orden" <?php if(request('orden') == 'nro_orden'): ?> selected <?php endif; ?>>OT</option>
                    <option value="nombre" <?php if(request('orden') == 'nombre'): ?> selected <?php endif; ?>>Nombre Personal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm m-1">Buscar</button>
            <button class="btn btn-success btn-sm m-1" onclick="toExcel()">Excel</button>

        </div>
    </form>

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
            
            <td>Nombres y Apellidos</td>
	    <td>DNI</td>
            <td>Días rabajados</td>
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
                
                <td><?php echo e($i->apellidos); ?> <?php echo e($i->nombres); ?></a>
		<td><?php echo e($i->doc_ide); ?></td>
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
                <?php ($ots=\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT personal,orden_trabajo FROM marcacion where personal=".$i->id." and fecha between '".request("f1")." 00:00:01' and '".request("f2")." 23:59:59' group by personal,orden_trabajo"))); ?>

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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        if ($(".txtdate").val() == "") {
            $(".txtdate").val(getYYYYMMDD())
        }

        function getYYYYMMDD() {
            const d = new Date()
            return new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000).toISOString().split('T')[0]
        }

        function toExcel() {
            var f1 = document.getElementById("f1").value;
            var f2 = document.getElementById("f2").value;
            var orden = document.getElementById("orden").value;

            var route = "<?php echo e(route('admin.reporte.asistencia-resumen.export')); ?>"
            window.open(route + '?f1=' + f1 + '&f2=' + f2 + '&orden=' + orden)

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/asistencia-personal-resumen.blade.php ENDPATH**/ ?>