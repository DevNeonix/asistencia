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
                    <option value="nombre" <?php if(request('orden') == 'apellidos'): ?> selected <?php endif; ?>>Nombre Personal</option>
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
            <th colspan="2">Personal</th>
            <th colspan="<?php echo e(count($dates)); ?>">Días</th>
            <th>Horas Trabajadas</th>
            <th colspan="3">Horas Extras</th>
        </tr>
        <tr>
            <td colspan="2"></td>
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
                <td><?php echo e($i->id); ?> <a href="<?php echo e(route('admin.personal.edit',$i->id)); ?>"><?php echo e($i->apellidos); ?>, <?php echo e($i->nombres); ?></a>
                </td>

                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($x = \App\Models\Marcacion::where('personal',$i->id)->where('fechaymd',$d)->get()); ?>
                    <?php ($f = \App\Models\Falta::where('personal',$i->id)->where('fecha',$d)->get()); ?>

                    <td>

                        <?php if(count($f)> 0): ?>

                            <p>Se ha reportado la falta: </p>
                            <ul>
                                <?php $__currentLoopData = $f; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-danger"><?php echo e($ff->orden_trabajo->nro_orden."-".$ff->orden_trabajo->cliente."-".$ff->orden_trabajo->producto_fabricar); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                        <?php else: ?>

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
                        <?php endif; ?>

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

            var route = "<?php echo e(route('admin.reporte.asistencia.export')); ?>"
            window.open(route + '?f1=' + f1 + '&f2=' + f2 + '&orden=' + orden)

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/asistencia-personal.blade.php ENDPATH**/ ?>