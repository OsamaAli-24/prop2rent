<?php
// get_proof.php - Updated for your "receipts" folder structure

$filename = $_GET['img'] ?? null;

if (!$filename) {
    die("No image specified.");
}

// remove any folder paths from the filename just in case the DB has "receipts/image.jpg"
$cleanName = basename($filename);

// Define ALL possible places the image could be hiding based on your screenshot
$possiblePaths = [
    // 1. Inside 'receipts' (Most likely based on your photo)
    __DIR__ . '/storage/app/public/receipts/' . $cleanName,
    
    // 2. Inside 'payment_proofs'
    __DIR__ . '/storage/app/public/payment_proofs/' . $cleanName,
    
    // 3. Just inside 'public'
    __DIR__ . '/storage/app/public/' . $cleanName,
    
    // 4. Try the standard Laravel structure (going up one level) just in case
    __DIR__ . '/../storage/app/public/receipts/' . $cleanName,
];

$realPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $realPath = $path;
        break;
    }
}

if ($realPath && is_file($realPath)) {
    // Serve the file
    $ext = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
    $mime = match ($ext) {
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'pdf' => 'application/pdf',
        default => 'application/octet-stream',
    };
    
    header("Content-Type: $mime");
    header("Content-Length: " . filesize($realPath));
    readfile($realPath);
    exit;
} else {
    // Debug info so we know what failed
    echo "<h1>Image Not Found</h1>";
    echo "<p>Looking for file: <b>$cleanName</b></p>";
    echo "<p>I checked these spots:</p><ul>";
    foreach ($possiblePaths as $p) {
        echo "<li>" . htmlspecialchars($p) . " " . (file_exists($p) ? "✅" : "❌") . "</li>";
    }
    echo "</ul>";
}
?>