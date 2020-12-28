<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.ots.update',$ot->id)); ?>" method="post">
                        <div class="form-group">
                            <label>Nro Orden</label>
                            <input type="text" class="form-control" name="nro_orden" value="<?php echo e($ot->nro_orden); ?>">
                        </div>
                        <div class="form-group">
                            <label>Producto a Fabricar</label>
                            <input type="text" class="form-control" name="producto_fabricar"
                                   value="<?php echo e($ot->producto_fabricar); ?>">
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" name="cliente" value="<?php echo e($ot->cliente); ?>">
                        </div>
                        <div class="form-group">
                            <label>Centro de Costo</label>
                            <select name="centro_costo_id" id="centro_costo_id" class="form-control">
                                <option></option>
                                <?php
                                    $centroCostos = \App\Models\CentroCosto::all();
                                ?>
                                <?php $__currentLoopData = $centroCostos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($costo->id); ?>"
                                            <?php if($ot->centro_costo_id == $costo->id): ?> selected <?php endif; ?>><?php echo e($costo->codigo."-".$costo->detalle); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ubicacion</label>
                            <input type="text" class="form-control" name="ubicacion" value="<?php echo e($ot->ubicacion); ?>">
                        </div>
                        <div class="form-group">
                            <label>Viático S/.</label>
                            <input type="text" class="form-control" name="viatico" value="<?php echo e($ot->viatico); ?>">
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="1" <?php echo e($ot->estado == 1? 'selected':''); ?>>Habilitado</option>
                                <option value="0" <?php echo e($ot->estado == 0? 'selected':''); ?>>Inhabilitado</option>
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
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row py-2">
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

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Personal</th>
                            <th>Nro Días asistidos</th>
                            <th>Soles por hora</th>
                            <th>Total</th>
                        </tr>
                        </thead>

                        <?php
                            $t = \App\Models\Marcacion::where('orden_trabajo',$ot->id)->groupBy(['personal','orden_trabajo'])->whereBetween('fechaymd', [$fini, $ffin])->selectRaw('count(*) as total, personal,orden_trabajo')->get();
                            $tot = 0;
                        ?>
                        <tbody>
                        <?php $__currentLoopData = $t; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i->personal_complete->apellidos." ".$i->personal_complete->nombres); ?></td>
                                <td><?php echo e(round($i->total,2)); ?></td>
                                <td><?php echo e(round($i->personal_complete->costo_hora,2)); ?></td>
                                <td><?php echo e(round($i->personal_complete->costo_hora*8*$i->total,2)); ?></td>
                                <?php
                                    $tot = $tot + ($i->personal_complete->costo_hora*8*$i->total);
                                ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td colspan="3"></td>
                            <td><?php echo e(round($tot,2)); ?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/ots_edit.blade.php ENDPATH**/ ?>