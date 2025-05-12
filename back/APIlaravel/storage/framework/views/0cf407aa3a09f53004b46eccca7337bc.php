<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($planning['viatge']['titol'] ?? 'Planificació del viatge'); ?></title>
    <style>
        @page {
            margin: 40px 40px 60px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            position: relative;
        }

        header {
            position: fixed;
            top: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .logo {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 60px;
        }

        h1, h2, h3 {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        .day-title {
            margin-top: 30px;
            font-size: 18px;
        }

        .activity {
            margin-bottom: 15px;
        }

        .activity strong {
            display: block;
        }

        .no-activities {
            font-style: italic;
        }

        .price {
            color: #444;
        }
    </style>
</head>
<body>

    
    <header>
        <img src="<?php echo e(public_path('images/logo.png')); ?>" class="logo" alt="Logo">
    </header>

    <footer>
        Pla de viatge generat automàticament
    </footer>

    
    <h1><?php echo e($planning['viatge']['titol'] ?? 'Planificació del viatge'); ?></h1>
    <h3>Preu total estimat: <?php echo e($planning['viatge']['preuTotal'] ?? 'No disponible'); ?>€</h3>

    <div class="page-break"></div>

    
    <?php $__currentLoopData = $planning['viatge']['dies'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2 class="day-title">Dia <?php echo e($index + 1); ?></h2>

        <?php if(!empty($dia['activitats'])): ?>
            <?php $__currentLoopData = $dia['activitats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="activity">
                    <strong><?php echo e($act['horari'] ?? 'Sense horari'); ?> | <?php echo e($act['nom'] ?? 'Activitat'); ?></strong>
                    <div><?php echo e($act['descripcio'] ?? ''); ?></div>
                    <div class="price">Preu: <?php echo e($act['preu'] ?? 'Preu no disponible'); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="no-activities">No hi ha activitats definides per aquest dia.</div>
        <?php endif; ?>

        <div class="page-break"></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>
<?php /**PATH /var/www/resources/views/pdf/planning.blade.php ENDPATH**/ ?>