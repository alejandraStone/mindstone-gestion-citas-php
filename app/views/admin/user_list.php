<?php
require_once realpath(__DIR__ . '/../../config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
</head>
<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php';
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>

<main class="flex-1 mt-10 bg-white min-h-screen flex flex-col items-center p-6 rounded-xl border border-brand-200">
    <h1 class="text-2xl font-semibold mb-6 text-brand-900 font-titulo text-left">User List</h1>
    <div class="container mx-auto py-10">
        <form method="get"
            class="mb-10 flex flex-col md:flex-row md:justify-end md:items-end flex-wrap gap-4 w-full">
            <input type="text" name="search"
                value="<?= h($search) ?>"
                placeholder="Search by name, last name or email"
                class="border rounded px-3 py-2 flex-1 min-w-[180px]" />
            <select name="role"
                class="border rounded px-3 py-2 flex-1 min-w-[120px]">
                <option value="">All roles</option>
                <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit"
                class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded shadow transition-all text-center">
                Filter
            </button>
            <a href="export_users_pdf.php?search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>"
                class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded shadow transition-all text-center"
                target="_blank">
                Export PDF
            </a>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 bg-white rounded-xl">
                <thead>
                    <tr class="bg-brand-300">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">First Name</th>
                        <th class="px-4 py-2 border">Last Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Phone</th>
                        <th class="px-4 py-2 border">Role</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-4 py-2 border"><?= h($user['id']) ?></td>
                            <td class="px-4 py-2 border"><?= h($user['name']) ?></td>
                            <td class="px-4 py-2 border"><?= h($user['lastName']) ?></td>
                            <td class="px-4 py-2 border"><?= h($user['email']) ?></td>
                            <td class="px-4 py-2 border"><?= h($user['phone']) ?></td>
                            <td class="px-4 py-2 border"><?= h($user['role']) ?></td>
                            <td class="px-4 py-2 border flex flex-col gap-2 md:flex-row">
                                <!-- Edit User Button -->
                                <button class="edit-class-btn border border-brand-200 text-brand-900 bg-cyan-100 hover:bg-cyan-200 rounded px-3 py-1 text-xs transition"
                                    data-id="<?= h($user['id']) ?>"
                                    data-name="<?= h($user['name']) ?>"
                                    data-lastname="<?= h($user['lastName']) ?>"
                                    data-email="<?= h($user['email']) ?>"
                                    data-phone="<?= h($user['phone']) ?>"
                                    data-role="<?= h($user['role']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                <!-- Delete User Button -->
                                <button class="btn-delete-user border border-brand-200 bg-red-100 hover:bg-red-200 rounded px-3 py-1 text-xs transition"
                                    data-id="<?= h($user['id']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                                <!-- Reset Password Button -->
                                <button class="btn-reset-user border border-brand-200 bg-yellow-100 hover:bg-yellow-200 rounded px-3 py-1 text-xs transition"
                                    data-id="<?= h($user['id']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true" data-slot="icon" class="w-5 h-5 text-brand-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-6 flex gap-2 items-center justify-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>"
                    class="px-3 py-1 rounded <?= $i === $page ? 'bg-brand-400 text-white' : 'bg-gray-200' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
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
</body>
<script src="<?= BASE_URL ?>/public/js/modules/user_crud.js"></script>

</html>