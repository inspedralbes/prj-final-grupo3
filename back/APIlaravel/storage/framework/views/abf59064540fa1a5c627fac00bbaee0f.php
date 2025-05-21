<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>El teu pla de viatge</title>
</head>
<body>
    <h2>Hola <?php echo e($user->name); ?>,</h2>

    <p>Ja tens preparat el teu pla de viatge! T'adjuntem un PDF amb tota la planificació.</p>

    <p><strong>Títol:</strong> <?php echo e($planning['viatge']['titol'] ?? 'Sense títol'); ?></p>
    <p><strong>Preu estimat:</strong> <?php echo e($planning['viatge']['preuTotal'] ?? 'No disponible'); ?> €</p>
    <p><strong>Dies:</strong> <?php echo e(count($planning['viatge']['dies'] ?? [])); ?></p>

    <p>Bon viatge! 🌍</p>
</body>
</html>
<?php /**PATH /var/www/resources/views/sendemail.blade.php ENDPATH**/ ?>