<?php $__env->startSection('content'); ?>
<div class="flex flex-col justify-center items-center m-5 gap-5">
    <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-6 w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <?php echo csrf_field(); ?>
        <p class="text-2xl font-bold text-gray-800 mb-6">Admin | Login</p>
        <div>
            <label for="username" class="block text-lg font-medium text-gray-700">Nom d'usuari</label>
            <input type="text" name="username" id="username" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="admin" value="<?php echo e(old('username')); ?>">
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="password" class="block text-lg font-medium text-gray-700">Contrasenya</label>
            <input type="password" name="password" id="password" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="*****">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Iniciar sessió</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/login.blade.php ENDPATH**/ ?>