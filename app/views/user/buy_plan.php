<?php
require_once __DIR__ . '/../../../app/config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';

//Obttengo todos los bonos activos para meter los id en las cards
$conexion = getPDO();
$bonusModel = new Bonus($conexion);
$bonos = $bonusModel->getAllBonos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Dashboard-User</title>
</head>

<!-- Layout dashboard header y aside -->
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard_user.php'; ?>
<main class="flex-1 lg:flex-col mt-10">

    <!-- Sección de Bonos-->
    <section class="w-full bg-brand-50 py-4 px-4 pb-20 overflow-x-hidden">
        <div class="max-w-6xl mx-auto text-center" data-aos="fade-up">
            <!-- Título -->
            <div class="p-4 md:p-6 lg:p-6">
                <h2 class="titulo-gradiente text-center">
                    <span class="titulo-punto">·</span>
                    Your Pilates Journey Starts Here
                    <span class="titulo-punto">·</span>
                </h2>
                <!-- Subtítulo -->
                <p class="text-brand-700 text-base mb-6 sm:text-lg max-w-xl mx-auto aos-init" data-aos="fade-up" data-aos-delay="100">
                    Choose the option that aligns best with your rhythm and goals.
                </p>
            </div>
            <!-- Grid con los 4 bonos en una fila -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <?php if ($bonos['success'] && !empty($bonos['bonos'])): ?>
                    <?php foreach ($bonos['bonos'] as $bono): ?>
                        <div class="rounded-3xl <?= $bono['color'] ?? 'bg-brand-600' ?> text-white p-8 flex flex-col justify-between shadow-xl transform hover:scale-105 transition-transform duration-300">
                            <div>
                                <?php if (!empty($bono['tag'])): ?>
                                    <span class="inline-block bg-verdeOlivaMasClaro text-oliveShade px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <?= htmlspecialchars($bono['tag']) ?>
                                    </span>
                                <?php endif; ?>
                                <h3 class="text-2xl font-titulo mb-2"><?= htmlspecialchars($bono['name']) ?></h3>
                                <p class="text-xs mb-6"><?= nl2br(htmlspecialchars($bono['description'])) ?></p>
                            </div>
                            <div>
                                <div class="flex items-baseline justify-center gap-2 mb-6">
                                    <span class="text-5xl font-bold"><?= intval($bono['price']) ?></span>
                                    <span class="text-xl">€</span>
                                </div>
                                <form method="POST" action="<?= BASE_URL ?>app/views/user/checkout.php">
                                    <input type="hidden" name="bonus_id" value="<?= $bono['id'] ?>">
                                    <button type="submit"
                                        class="block w-full bg-verdeOlivaMasClaro text-oliveShade font-semibold py-3 rounded-full hover:bg-verdeOlivaClaro transition">
                                        Buy Now
                                    </button>
                                </form>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No active bonuses found.</p>
                <?php endif; ?>
            </div>

        </div>
    </section>

</main>
</div><!-- cierre del div del Contenedor del aside y main -->

</body><!-- cierre del body del Contenedor del aside y main -->

</html>