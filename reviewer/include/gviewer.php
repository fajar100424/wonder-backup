<?php
require (dirname(__DIR__, 2) . "/dashboard/func/functions.php"); // Pastikan Anda menyertakan file konfigurasi database

$id_history = 9; // Ambil ID dari parameter URL
$fileData = getGoogleDocsViewerUrl($id_history);

if ($fileData) {
    $filePath = 'dashboard/assets/wonder/' . $fileData['document'];
    $fileUrl = 'https://wonderppp.my.id/' . $filePath; // Ganti dengan URL yang sesuai
    $googleDocsUrl = "https://docs.google.com/viewer?url=" . urlencode($fileUrl) . "&embedded=true";
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Docs Viewer</title>
</head>
<body>
    <iframe src="<?= $googleDocsUrl ?>" width="100%" height="600px"></iframe>
</body>
</html>