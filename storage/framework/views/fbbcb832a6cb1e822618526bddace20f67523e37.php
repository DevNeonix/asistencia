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


        <table class="table my-2">
            <thead>
            <tr>
                <th>Personal</th>
                <th>OT</th>
                <th>Fecha</th>
            </tr>
            </thead>

            <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i->nombre); ?></td>
                    <td><?php echo $i->cliente." <br> ".$i->producto_fabricar; ?></td>
                    <td><?php echo e($i->fecha); ?></td>
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
            window.open(route + '?f1=' + f1 + '&f2=' + f2+'&orden='+orden)

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/reportes/asistencia.blade.php ENDPATH**/ ?>