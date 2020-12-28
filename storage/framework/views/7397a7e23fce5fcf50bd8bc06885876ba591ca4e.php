<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.personal.update',$personal->id)); ?>" method="post">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" value="<?php echo e($personal->nombres); ?>">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="<?php echo e($personal->apellidos); ?>">
                        </div>
                        <div class="form-group">
                            <label>Doc. Identidad</label>
                            <input type="text" class="form-control" name="doc_ide" value="<?php echo e($personal->doc_ide); ?>">
                        </div>
                        <div class="form-group d-none">
                            <label>Remuneración</label>
                            <input type="text" class="form-control" name="remuneracion"
                                   value="<?php echo e($personal->remuneracion); ?>">
                        </div>
                        <div class="form-group">
                            <label>Asignación Familiar</label>
                            <input type="text" class="form-control" name="asignacion_familiar"
                                   value="<?php echo e($personal->asignacion_familiar); ?>">
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">

                                <?php
                                $roles = \Illuminate\Support\Facades\DB::table('rol_empleado')->get();
                                ?>

                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($rol->id); ?>" <?php echo e($personal->tipo == $rol->id?'selected':''); ?>><?php echo e($rol->detalle); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <?php
                $fini =request('fini');
                $ffin =request('ffin');

                if ($fini == null){
                    $fini=date('Y-m-01');
                }
                if ($ffin == null){
                    $ffin=date('Y-m-t');
                }

                $today = \Carbon\Carbon::make($fini);
                $dates = [];


                for($i=0; $i <= Carbon\Carbon::make($ffin)->diffInDays($today); ++$i) {

                    $dates[] = \Carbon\Carbon::make($today)->addDays($i)->format('y-m-d');
                }



            ?>

            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row py-2">

                            <div class="col-4">
                                <div class="form-inline">
                                    <label>Fecha Inicial &nbsp;
                                        <input type="date" name="fini" class="form-control" value="<?php echo e($fini); ?>"> </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-inline">
                                    <label>Fecha Final &nbsp;
                                        <input type="date" name="ffin" class="form-control" value="<?php echo e($ffin); ?>"> </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </div>

                        </div>
                    </form>
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Ot</th>
                            <th>H. trabajadas</th>
                            <th>H. extras</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            $horasTrabajadas = 0;
                            $faltaRemunerada = 0;
                            $faltadescontada = 0;
                        ?>
                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $marcas = \App\Models\ViewMarcacionPersonal::where('id_personal',$personal->id)->where('fechaymd','=',$f)->get()
                            ?>
                            <?php if(count($marcas) >=1): ?>
                                <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($marca->fechaymd); ?>

                                        </td>
                                        <td>
                                            <?php echo e($marca->nro_orden); ?> <?php echo e($marca->cliente); ?> <?php echo e($marca->producto_fabricar); ?>

                                        </td>
                                        <?php
                                            $nroMarcasPordia = \App\Models\Marcacion::where('personal',$marca->id_personal)
                                                                        ->where('fechaymd',$marca->fechaymd)
                                                                        ->distinct()
                                                                        ->get('orden_trabajo','fechaymd')
                                                                        ->count();

                                        ?>
                                        <td><?php echo e(round(8/$nroMarcasPordia,2)); ?></td>
                                        <?php
                                            $horasTrabajadas = $horasTrabajadas + round(8/$nroMarcasPordia,2);
                                        ?>
                                        <td>
                                            <?php echo e(round($marca->minutos_extras/60,2)); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td><?php echo e($f); ?></td>
                                    <?php
                                        $falta = \App\Models\Falta::where('fecha',$f)->where('personal',$personal->id)->first()
                                    ?>
                                    <?php if($falta == null): ?>
                                        <td class="text-danger" colspan="3">

                                            Marcación no registrada
                                            <?php
                                                $nomdia = \Illuminate\Support\Str::upper(\Illuminate\Support\Carbon::make($f )->locale('es_ES')->dayName);
                                            ?>
                                            <?php echo e($nomdia); ?>

                                        </td>
                                        <td>
                                            <?php
                                                if($nomdia == "DOMINGO"){
                                                    $horasTrabajadas=$horasTrabajadas+8;
                                                    echo "8";
                                                }else{
                                                    $faltadescontada = $faltadescontada +1;
                                                }

                                            ?>

                                        </td>
                                    <?php else: ?>
                                        <td class="text-danger font-weight-bold text-uppercase">
                                            <?php
                                                $dsfalta = "";
                                                switch ($falta->falta){
                                                    case 1:
                                                        $dsfalta='vacaciones';
                                                        $faltaRemunerada = $faltaRemunerada +8;
                                                        break;
                                                    case 2:
                                                        $dsfalta='Permiso';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    case 3:
                                                        $dsfalta='Falta injustificada';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    case 4:
                                                        $dsfalta='Licencia médica';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    default:
                                                        $dsfalta='NA';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                }
                                            ?>
                                            <?php echo e($dsfalta); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="bg-dark text-white">
                            <td colspan="2">Horas Trabajadas</td>
                            <td><?php echo e($horasTrabajadas); ?></td>
                            <td><?php echo e(round(($horasTrabajadas)*$personal->costo_hora,2)); ?></td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Permisos Remunerados</td>
                            <td><?php echo e($faltaRemunerada); ?></td>
                            <td>S/. <?php echo e(round(($faltaRemunerada)*$personal->costo_hora,2)); ?></td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Faltas</td>
                            <td><?php echo e($faltadescontada); ?> días</td>
                            <td>S/. <?php echo e(round(($faltadescontada*8)*$personal->costo_hora,2)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <hr></td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Resumen de Pago</td>
                            <td><?php echo e($horasTrabajadas + $faltaRemunerada); ?></td>
                            <td>S/. <?php echo e(round(($horasTrabajadas + $faltaRemunerada)*$personal->costo_hora,2)); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function cambiaTipo() {
            var tipo = $("#tipo").val();
            if (parseInt(tipo) == 0 || parseInt(tipo) == -1) {
                $("#supervisor-auth").css("display", "none")
            } else {
                $("#supervisor-auth").css("display", "block")
            }
        }

        cambiaTipo();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/personal_edit.blade.php ENDPATH**/ ?>