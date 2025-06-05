<?php
require_once __DIR__ . '/../../../app/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Payment Success</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css" />
</head>
<body class="bg-green-50 min-h-screen flex flex-col items-center justify-center">
<?php if (isset($error)): ?>
    <h1 class="text-3xl font-bold text-red-700 mb-4">❌ Payment Error</h1>
    <p class="text-lg text-red-600 mb-6"><?= htmlspecialchars($error) ?></p>
    <a href="<?= BASE_URL ?>" class="px-6 py-3 bg-red-700 text-white rounded-full hover:bg-red-800 transition">Go Back</a>
<?php else: ?>
    <h1 class="text-3xl font-bold text-green-700 mb-4">🎉 Purchase Successful!</h1>
    <p class="text-lg text-green-600 mb-6">
        Your bonus <strong><?= htmlspecialchars($bonusName) ?></strong> is now active.<br>
        Valid until <?= htmlspecialchars($validUntil) ?>.
    </p>
    <a href="<?= BASE_URL ?>app/views/user/reservations.php" class="px-6 py-3 bg-green-700 text-white rounded-full hover:bg-green-800 transition">
        Go to your TimeTable
    </a>
<?php endif; ?>
</body>
</html>
