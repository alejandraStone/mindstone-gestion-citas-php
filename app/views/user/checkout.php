<?php
require_once realpath(__DIR__ . '/../../config/config.php');
require_once ROOT_PATH . '/app/controllers/bono_checkout_controller.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'public/inicio.php');
    exit;
}

$bonus = null;
if (isset($_POST['bonus_id'])) {
    $bonusId = intval($_POST['bonus_id']);
    $bonus = getBonusData($bonusId);
}

if (!$bonus) {
    header('Location: ' . BASE_URL . 'public/inicio.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard_user.php'; ?>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Resumen del bono -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-lg">
                <h1 class="text-2xl font-bold text-brand-800 mb-6">Plan Details</h1>

                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="flex-shrink-0 w-full md:w-1/3">
                        <div class="bg-brand-100 text-brand-800 font-semibold text-center py-8 px-4 rounded-xl shadow-inner">
                            <h2 class="text-xl"><?= htmlspecialchars($bonus['name']) ?></h2>
                            <p class="text-sm mt-2"><?= htmlspecialchars($bonus['description']) ?></p>
                            <div class="mt-6 text-3xl font-bold text-oliveShade">
                                <?= number_format($bonus['price'], 2) ?> <span class="text-lg">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <h3 class="font-semibold text-brand-700">📅 Duración</h3>
                            <p class="text-sm text-brand-600">Este bono es válido por 4 semanas desde la fecha de compra.</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-brand-700">🔁 Renovación</h3>
                            <p class="text-sm text-brand-600">No se renueva automáticamente. Deberás comprar un nuevo bono cuando expire.</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-brand-700">📌 Reglas de uso</h3>
                            <ul class="list-disc list-inside text-sm text-brand-600 space-y-1">
                                <li>1 clase = 1 crédito</li>
                                <li>El bono no es acumulable de mes a mes</li>
                                <li>No se aceptan devoluciones una vez comenzado el periodo</li>
                                <li>Solo puedes usarlo tú (no es transferible)</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold text-brand-700">🛡️ Política de compra</h3>
                            <p class="text-sm text-brand-600">
                                Al confirmar tu compra, aceptas nuestras condiciones de uso. Podrás ver tu bono activo en tu panel de usuario.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmación / botón pago -->
            <div class="bg-white p-6 rounded-2xl shadow-lg h-fit">
                <h2 class="text-xl font-bold text-brand-800 mb-4">Ready to purchase?</h2>
                <p class="text-sm text-brand-600 mb-6">
                    Presiona el botón para completar tu compra a través de Stripe de forma segura.
                </p>

                <form id="checkout-form" action="<?= BASE_URL ?>app/controllers/create_checkout_session_controller.php" method="POST">
                    <input type="hidden" name="bonus_id" value="<?= $bonus['id'] ?>">
                    <button
                        type="submit"
                        class="w-full bg-oliveShade hover:bg-oliveShade/90 text-white font-semibold py-3 px-6 rounded-full text-lg transition">
                        Confirm and Pay Securely
                    </button>
                </form>

                <p class="mt-6 text-xs text-gray-400 text-center">
                    Transacción segura mediante Stripe. No almacenamos tus datos bancarios.
                </p>
            </div>

        </div>
    </main>

    <script>
        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita envío clásico

            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.url) {
                window.location.href = result.url; // 🔁 Redirige al checkout de Stripe
            } else {
                alert(result.error || "Something went wrong");
            }
        });
    </script>

</body>

</html>