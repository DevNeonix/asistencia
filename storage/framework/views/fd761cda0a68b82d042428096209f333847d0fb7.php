<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.ots.store')); ?>" method="post" >
                        <div class="form-group">
                            <label>Nro Orden</label>
                            <input type="text" class="form-control" name="nro_orden" value="<?php echo e(old('nro_orden')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Producto a Fabricar</label>
                            <input type="text" class="form-control" name="producto_fabricar" value="<?php echo e(old('producto_fabricar')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" name="cliente" value="<?php echo e(old('cliente')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Centro de Costo</label>
                            <select name="centro_costo_id" id="centro_costo_id" class="form-control">
                                <option ></option>
                                <?php
                                    $centroCostos = \App\Models\CentroCosto::all();
                                ?>
                                <?php $__currentLoopData = $centroCostos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($costo->id); ?>" ><?php echo e($costo->codigo."-".$costo->detalle); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ubicacion</label>
                            <input type="text" class="form-control" name="ubicacion" value="<?php echo e(old('ubicacion','')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Viático S/.</label>
                            <input type="text" class="form-control" name="viatico" value="<?php echo e(old('viatico',0)); ?>">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/ots_create.blade.php ENDPATH**/ ?>