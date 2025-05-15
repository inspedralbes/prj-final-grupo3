<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>TriPlan | Pagina d'administració</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <div class="bg-gray-800 text-white py-10 text-center relative">
      <a href="<?php echo e(route('users')); ?>">
        <p class="text-3xl font-bold">PÀGINA D'ADMINISTRACIÓ</p>
        <p class="text-xs">CRUD | TRIPLAN</p>
      </a>
      <?php if(Auth::check()): ?>
      <div class="flex flex-row justify-center gap-4 mt-4">
      <a href="<?php echo e(route('users')); ?>"
        class="cursor-pointer text-basefont-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de
        usuaris</a>
      <a href="<?php echo e(route('countries')); ?>"
        class="cursor-pointer text-base font-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de països</a>
      <a href="<?php echo e(route('travel-types')); ?>"
        class="cursor-pointer text-base font-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de tipus del viatge</a>
      <a href="<?php echo e(route('movilities')); ?>"
        class="cursor-pointer text-base font-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de mobilitats</a>
      <a href="<?php echo e(route('budgets')); ?>"
        class="cursor-pointer text-base font-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de pressupost</a>
      <a href="<?php echo e(route('travels')); ?>"
        class="cursor-pointer text-base font-medium p-1 delay-75 hover:text-black hover:bg-white rounded-full transition">Gestió
        de viatges</a>
      
      </div>
    <?php endif; ?>
      <div class="absolute top-4 right-4">
        <?php if(Auth::check()): ?>
      <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <button type="submit"
        class="bg-gray-500 text-white px-2 pr-3 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
        <img src="<?php echo e(asset('icons/logout_icon.svg')); ?>" alt="" class="w-5 h-10"></button>
      </form>
    <?php endif; ?>
      </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow bg-gray-100">
      <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-4 text-center">
      <p class="text-sm">© 2024 TriPlan. Tots els drets reservats.</p>
    </footer>
  </div>
</body>

</html><?php /**PATH /var/www/resources/views/layout/index.blade.php ENDPATH**/ ?>