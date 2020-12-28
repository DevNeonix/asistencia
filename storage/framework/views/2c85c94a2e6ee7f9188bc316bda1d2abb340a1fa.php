<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.personal.store')); ?>" method="post">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" value="<?php echo e(old('nombres')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="<?php echo e(old('apellidos')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Doc. Identidad</label>
                            <input type="text" class="form-control" name="doc_ide" value="<?php echo e(old('doc_ide')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Remuneración</label>
                            <input type="text" class="form-control" name="remuneracion" value="<?php echo e(old('remuneracion')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Asignación Familiar</label>
                            <input type="text" class="form-control" name="asignacion_familiar" value="<?php echo e(old('asignacion_familiar')); ?>">
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">

                                <?php
                                $roles = \Illuminate\Support\Facades\DB::table('rol_empleado')->get();
                                ?>

                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($rol->id); ?>" ><?php echo e($rol->detalle); ?></option>
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function cambiaTipo() {
            var tipo = $("#tipo").val();
            if (tipo == 0) {
                $("#supervisor-auth").css("display", "none")
            } else {
                $("#supervisor-auth").css("display", "block")
            }
        }

        cambiaTipo();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/personal_create.blade.php ENDPATH**/ ?>