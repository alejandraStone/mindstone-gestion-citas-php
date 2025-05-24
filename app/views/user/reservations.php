<?php 
require_once realpath(__DIR__ . '/../../config/config.php');
require_once realpath(__DIR__ . '/../../session/session_manager.php'); // isAuthenticated() y getUser()
require_once ROOT_PATH . '/app/models/ClassModel.php'; // Modelo para obtener clases
require_once ROOT_PATH . '/app/views/layout/header.php'; // header

// Comprobar autenticación
if(!isAuthenticated()){
    header("Location: " . BASE_URL . "app/views/auth/login.php");
    exit;
} else {
    $user = getUser();
    echo "<h2 class='text-xl font-semibold mb-4'>Welcome, " . htmlspecialchars($user['name']) . "</h2>";

    // Obtener todas las clases desde la base de datos
    $classModel = new ClassModel(getPDO());
    $classes = $classModel->getAllClasses(); // Este método debe devolverte todas las clases activas
    ?>
    
    <h2 class="text-lg font-bold mb-2">Available Classes</h2>
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mb-10">
        <?php if(empty($classes)): ?>
            <p class="col-span-full text-gray-500">No classes available at the moment.</p>
        <?php else: ?>
            <?php foreach($classes as $class): ?>
                <div class="bg-white rounded-xl shadow-md p-5 flex flex-col items-start justify-between gap-3">
                    <div>
                        <h3 class="text-brand-800 text-lg font-semibold mb-1"><?=htmlspecialchars($class['title'])?></h3>
                        <p class="text-sm text-brand-600 mb-1"><?=htmlspecialchars($class['description'])?></p>
                        <p class="text-xs text-gray-500 mb-1">
                            <span class="font-medium">Date:</span> <?=htmlspecialchars($class['date'])?> 
                            <span class="ml-2 font-medium">Time:</span> <?=htmlspecialchars($class['time'])?>
                        </p>
                        <p class="text-sm text-brand-700 mb-2">
                            <span class="font-semibold">Price:</span> <?=number_format($class['price'], 2)?> €
                        </p>
                    </div>
                    <button 
                        class="buy-class-btn bg-brand-400 hover:bg-brand-500 text-white font-bold py-2 px-6 rounded-lg transition-colors w-full"
                        data-class-id="<?=htmlspecialchars($class['id'])?>">
                        Reserve/Buy
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Mensaje de confirmación JS -->
    <div id="confirmation-message" class="confirmation-message" style="display:none;"></div>

    <!-- JS para reservar/comprar clases -->
    <script src="/mindStone/public/js/modules/book_lessons.js"></script>
    <style>
        .confirmation-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            font-size: 16px;
            z-index: 9999;
        }
    </style>
<?php
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/mindStone/app/views/layout/footer.php';
?>