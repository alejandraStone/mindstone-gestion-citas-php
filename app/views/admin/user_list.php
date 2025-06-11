<?php
require_once realpath(__DIR__ . '/../../config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>User List</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
</head>
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php';
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>

<main class="mt-10 bg-white min-h-screen flex-1 flex flex-col items-center rounded-xl border border-brand-200 box-border max-w-full overflow-hidden">
    <!-- Header: título + filtros + crear usuario -->
    <div class=" w-full max-w-7xl p-6 flex flex-col lg:flex-row md:justify-between md:items-center gap-4 mt-10">

        <!-- Título -->
        <h1 class="text-2xl font-semibold text-brand-900 font-titulo whitespace-nowrap">
            User List
        </h1>

        <!-- Filtros + botón en bloque a la derecha -->
        <div class="flex flex-col lg:flex-row lg:items-center gap-4 lg:justify-end">
            <form method="get" class="flex flex-col lg:flex-row lg:items-center justify-center gap-4 lg:w-auto">
                <!-- Inputs y selects: ocupan todo el ancho en móvil y crecen en fila en lg -->
                <div class="flex flex-col lg:flex-row lg:items-center gap-4 lg:w-auto flex-grow">
                    <input type="text" name="search" value="<?= h($search) ?>"
                        placeholder="Search by name, last name or email"
                        class="border rounded px-3 py-2 w-full lg:max-w-[300px]" />

                    <select name="role"
                        class="border rounded px-3 py-2 w-full lg:max-w-[160px]">
                        <option value="">All roles</option>
                        <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <!-- Botones: apilados en móvil, fila en lg, con mínimo ancho y sin wrap en texto -->
                <div class="flex flex-col lg:flex-row gap-4 items-center+ lg:w-auto">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition w-full lg:w-auto min-w-[120px] whitespace-nowrap">
                        Filter
                    </button>

                    <a href="export_users_pdf.php?search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>"
                        class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition text-center w-full lg:w-auto min-w-[120px] whitespace-nowrap"
                        target="_blank">
                        Export PDF
                    </a>
                </div>
            </form>

            <!-- Botón crear usuario: full width en móvil, auto en lg, mínimo ancho y sin wrap -->
            <button id="toggle-add-user"
                class="bg-brand-600 hover:bg-brand-700 text-white font-medium text-base py-2 px-6 rounded-lg transition w-full lg:w-auto whitespace-nowrap">
                Create User
            </button>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="w-full max-w-7xl p-6 overflow-x-auto border-brand-100 rounded-xl mt-6">
        <table class="w-full table-auto border-separate border-brand-200 border rounded-xl">
            <thead class="bg-brand-50 text-brand-700 text-sm uppercase text-left">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">First Name</th>
                    <th class="px-4 py-3">Last Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-brand-900 divide-y divide-brand-100 text-sm">
                <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-brand-50">
                        <td class="px-4 py-3 font-semibold"><?= h($user['id']) ?></td>
                        <td class="px-4 py-3"><?= h($user['name']) ?></td>
                        <td class="px-4 py-3"><?= h($user['lastName']) ?></td>
                        <td class="px-4 py-3"><?= h($user['email']) ?></td>
                        <td class="px-4 py-3"><?= h($user['phone']) ?></td>
                        <td class="px-4 py-3"><?= h($user['role']) ?></td>
                        <td class="px-4 py-3 flex flex-col gap-2 md:flex-row">
                            <!-- Botones como estaban -->
                            <button class="edit-class-btn text-brand-600 hover:text-brand-900 font-medium text-sm mr-2"
                                data-id="<?= h($user['id']) ?>"
                                data-name="<?= h($user['name']) ?>"
                                data-lastname="<?= h($user['lastName']) ?>"
                                data-email="<?= h($user['email']) ?>"
                                data-phone="<?= h($user['phone']) ?>"
                                data-role="<?= h($user['role']) ?>">
                                <!-- SVG edit icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>
                            <button class="btn-delete-user text-brand-600 hover:text-brand-900 font-medium text-sm mr-2"
                                data-id="<?= h($user['id']) ?>">
                                <!-- SVG delete icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6 flex gap-2 items-center justify-center mb-6">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>"
                class="px-3 py-1 rounded <?= $i === $page ? 'bg-brand-400 text-white' : 'bg-gray-200' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <!-- Contenedor del formulario oculto para hacer agregar usuarios -->
    <div id="create-user-container" class="hidden mt-10 p-6 w-full max-w-7xl">
        <?php include ROOT_PATH . '/app/views/admin/create_user.php'; ?>
    </div>
</main>

<!-- Edit User Popup Modal -->
<div id="edit-user-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
        <button id="close-edit-user-modal"
            class="absolute top-2 right-2 text-xl text-brand-700 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Edit User</h2>
        <form id="edit-user-form" class="space-y-4">
            <input type="hidden" id="edit-user-id">

            <div>
                <label class="block mb-1 text-brand-700">First Name</label>
                <input type="text" id="edit-user-name" class="w-full border rounded px-2 py-1">
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Last Name</label>
                <input type="text" id="edit-user-lastname" class="w-full border rounded px-2 py-1">
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Email</label>
                <input type="email" id="edit-user-email" class="w-full border rounded px-2 py-1">
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Phone</label>
                <input type="text" id="edit-user-phone" class="w-full border rounded px-2 py-1">
            </div>
            <div>
                <label class="block mb-1 text-brand-700">Role</label>
                <select id="edit-user-role" class="w-full border rounded px-2 py-1">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div id="edit-user-form-message" class="text-center"></div>
            <button type="submit" class="bg-brand-700 text-white px-4 py-2 rounded hover:bg-brand-800 w-full">Save Changes</button>
        </form>
    </div>
</div>
</div>

<script type="module" src="<?= BASE_URL ?>/public/js/modules/user_crud.js"></script>

</body>

</html>