<?php
require_once __DIR__ . '/../../../app/config/config.php';
require_once ROOT_PATH . '/app/session/session_manager.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Payment Cancelled</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/output.css" />
</head>

<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center">

    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">Payment Cancelled</h1>
        <p class="text-gray-700 mb-6">
            It looks like you have cancelled the payment process. If it was an error, you can try again at any time. </p>
        <a href="<?= BASE_URL ?>app/views/user/reservations.php" class="inline-block bg-oliveShade hover:bg-oliveShade/90 text-white font-semibold py-3 px-6 rounded-full transition">
            Back to User Panel
        </a>
    </div>

</body>

</html>