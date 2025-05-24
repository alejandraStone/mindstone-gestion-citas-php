<?php
require_once realpath(__DIR__ . '/../../config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="<?= BASE_URL ?>/public/js/modules/user_crud.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Add User</title>
</head>
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>
<main class="flex-1 mt-10 bg-white min-h-screen flex flex-col items-center p-6 rounded-xl border border-brand-200">
    <h1 class="text-2xl font-semibold mb-10 text-brand-900 font-titulo text-left">Create a New User</h1>
    <form id="add-user-form" class="space-y-10 w-full max-w-5xl mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div>
                <label for="name" class="block font-semibold text-brand-800 mb-2">Name:</label>
                <input type="text" name="name" id="name" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="lastname" class="block font-semibold text-brand-800 mb-2">Last Name:</label>
                <input type="text" name="lastName" id="lastName" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="email" class="block font-semibold text-brand-800 mb-2">Email:</label>
                <input type="email" name="email" id="email" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="phone" class="block font-semibold text-brand-800 mb-2">Phone:</label>
                <input type="tel" name="phone" id="phone" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="password" class="block font-semibold text-brand-800 mb-2">Password:</label>
                <input type="password" name="password" id="password" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition" />
            </div>
            <div>
                <label for="role" class="block font-semibold text-brand-800 mb-2">Role:</label>
                <select name="role" id="role" required
                    class="w-full h-11 px-4 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 transition">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="flex justify-start gap-4">
            <button type="submit" id="submit-button"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Create User
            </button>
            <a href="<?= BASE_URL ?>app/controllers/user_list_controller.php" class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-none">
                Show Users
            </a>
        </div>
        <div id="form-message" class="mt-4 text-center text-sm font-semibold font-normal"></div>
    </form>
</main>
</div><!-- cierre del div del Contenedor del aside y main -->
</body>
</html>