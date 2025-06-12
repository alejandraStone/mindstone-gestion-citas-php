<?php
require_once __DIR__ . '/../../../app/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="<?= BASE_URL ?>/public/js/modules/user_crud.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title>Upload Invoice / PDF</title>
</head>

<?php require_once ROOT_PATH . '/app/views/layout/layout_dashboard.php'; ?>

<main class="flex-1 mt-6 bg-white min-h-screen flex flex-col items-center p-2 sm:p-6 rounded-xl border border-brand-200">
    <h1 class="text-lg sm:text-2xl font-semibold mb-6 sm:mb-10 text-brand-900 font-titulo w-full text-center">
        Upload Invoice / PDF
    </h1>
    <?php if (!empty($error)): ?>
        <div class="mb-4 text-red-700 font-semibold text-sm sm:text-base"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="mb-4 text-green-700 font-semibold text-sm sm:text-base"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form action="/mindStone/app/controllers/upload_files_controller.php" method="POST" enctype="multipart/form-data" class="space-y-6 w-full max-w-md sm:max-w-2xl mt-2 sm:mt-6">
        <div>
            <label for="pdf_file" class="block font-semibold text-brand-800 mb-2 text-sm">PDF file:</label>
            <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required
                class="w-full px-3 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 text-sm" />
        </div>
        <div>
            <label for="description" class="block font-semibold text-brand-800 mb-2 text-sm">Description:</label>
            <input type="text" name="description" id="description" maxlength="255" required
                class="w-full px-3 py-2 border border-brand-300 rounded-lg bg-white text-brand-900 text-sm" />
        </div>
        <button type="submit" class="w-full sm:w-auto bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-base">
            Upload PDF
        </button>
    </form>
    <!-- List of uploaded PDFs -->
    <h2 class="text-lg sm:text-2xl font-semibold my-6 sm:my-10 text-brand-900 font-titulo w-full text-center">
        Uploaded Invoices / PDFs
    </h2>
    <div class="w-full max-w-md sm:max-w-5xl">
        <div class="overflow-x-auto rounded-lg border border-brand-300">
            <table class="min-w-full table-auto text-sm sm:text-base">
                <thead>
                    <tr class="bg-brand-200">
                        <th class="px-2 sm:px-4 py-2 text-left">Description</th>
                        <th class="px-2 sm:px-4 py-2 text-left">Uploaded by</th>
                        <th class="px-2 sm:px-4 py-2 text-left">Date</th>
                        <th class="px-2 sm:px-4 py-2 text-left">Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pdfs)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">No PDF files uploaded.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pdfs as $pdf): ?>
                            <tr class="border-t border-brand-100">
                                <td class="px-2 sm:px-4 py-2"><?= htmlspecialchars($pdf['description']) ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= htmlspecialchars($pdf['name']) ?> <?= htmlspecialchars($pdf['lastName']) ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= htmlspecialchars($pdf['uploaded_at']) ?></td>
                                <td class="px-2 sm:px-4 py-2">
                                    <a href="/mindStone/app/controllers/pdf_download_controller.php?id=<?= $pdf['id'] ?>" class="text-blue-700 underline" target="_blank">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</div><!-- End of sidebar and main container -->
</body>
</html>