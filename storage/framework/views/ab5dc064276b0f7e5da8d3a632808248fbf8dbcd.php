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
    for ($a; $a <= $b;) {
        array_push($dates, $a->format('Y-m-d'));
        $a->addDay();
    }

    ?>

    <table class="table table-sm my-2 table-responsive">
        <thead>
        <tr>
            <th>TAREADO</th>
            <th>APELLIDOS Y NOMBRES</th>
            <th>DNI</th>
            <th>CC</th>
            <th>CENTRO DE COSTO</th>
            <th>UBICACION</th>
            <th>OT</th>
            <th>DESCRIPCION</th>
            <th>CLIENTE</th>
            <th>FECHA</th>
            <th>HORAS NORMALES</th>
            <th>HORAS EXTRAS</th>
            <th>HORAS EXTRAS 25%</th>
            <th>HORAS EXTRAS 35%</th>
            <th>HORAS EXTRAS 100%</th>
            <th>Viaticos</th>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                <?php
                $marcaciones = \App\Models\Marcacion::where('personal', $persona->id)->where('fechaymd', $day)->get();
                ?>
                <?php ($diaes = \App\Util\CommonUtils::getNombreDia(\Carbon\Carbon::make($day)->format('l'))); ?>
                <?php if($marcaciones->count() == 0): ?>

                    <tr>
                        <td colspan="30">No Asistió el día <?php echo e($day); ?> (<?php echo e($diaes); ?>)</td>
                    </tr>

                <?php else: ?>
                    <?php $__currentLoopData = $marcaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marcacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $ot = $marcacion->ot;
                        $cc = $ot->centro_costo;
                        $extra = ($marcacion->minutos_extra) / 60;
                        $extras25 = 0;
                        $extras35 = 0;
                        $extras100 = 0;
                        $horas = round(8 / $marcaciones->count(), 2);
                        if ($diaes == "domingo") {
                            if ($extra == 0){
                                $extras100 = 16;
                            }else{
                                $extras100 = $extra*2;
                            }

                            $horas = 0;
                        } else {

                            if ($extra <= 2) {
                                $extras25 = $extra;
                            } else {
                                $extras25 = 2;
                                $extras35 = $extra - $extras25;
                            }
                        }

                        ?>
                        <tr class="<?php echo e($diaes == "domingo"?'text-danger':''); ?>">
                            <td></td>
                            <td><?php echo e($persona->apellidos." ".$persona->nombre); ?></td>
                            <td><?php echo e($persona->doc_ide); ?></td>
                            <td><?php echo e($cc->codigo); ?></td>
                            <td><?php echo e($cc->detalle); ?></td>
                            <td><?php echo e($ot->ubicacion); ?></td>
                            <td><?php echo e($ot->nro_orden); ?></td>
                            <td><?php echo e($ot->producto_fabricar); ?></td>
                            <td><?php echo e($ot->cliente); ?></td>
                            <td><?php echo e($day); ?> (<?php echo e($diaes); ?>)</td>
                            <td><?php echo e($horas); ?></td>
                            <td><?php echo e($extra); ?></td>
                            <td><?php echo e($extras25); ?></td>
                            <td><?php echo e($extras35); ?></td>
                            <td><?php echo e($extras100); ?></td>
                            <td><?php echo e($marcacion->viatico); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

            var route = "<?php echo e(route('admin.tareo.export')); ?>"
            window.open(route + '?f1=' + f1 + '&f2=' + f2 + '&orden=' + orden)

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/tareo.blade.php ENDPATH**/ ?>