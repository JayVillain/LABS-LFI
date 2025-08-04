<?php
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'] ?? null;

    if ($file && $file['tmp_name']) {
        $target_file = $target_dir . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "✅ File uploaded: <a href='$target_file'>$target_file</a>";
        } else {
            echo "❌ Upload failed.";
        }
    } else {
        echo "❌ No file uploaded.";
    }
}
?>

<h3>Upload File</h3>
<form method="post" enctype="multipart/form-data">
    Select file:
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>
