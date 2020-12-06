<?php $__env->startSection('content'); ?>
    <table class="table table-sm">

        <thead>
        <tr>
            <th>Usuario</th>
            <th>Ruta</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <form action="<?php echo e(route('usuarios-menus.store')); ?>" method="POST">
            <tr>
                <td>
                    <select name="user_id" id="">
                        <?php ($users = \App\Models\User::all()); ?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td>
                    <select name="menu_id" id="">
                        <?php ($menus = \App\Models\Menu::all()); ?>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($menu->id); ?>"><?php echo e($menu->titulo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </td>
            </tr>
        </form>
        <?php $__currentLoopData = $user_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($mm->user->name); ?></td>
                <td><?php echo e($mm->menu->titulo); ?></td>
                <td>
                    <form action="<?php echo e(route('usuarios-menus.destroy',$mm->id)); ?>" method="POST">
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </tbody>


    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/asistencia/resources/views/pages/user_menu/index.blade.php ENDPATH**/ ?>