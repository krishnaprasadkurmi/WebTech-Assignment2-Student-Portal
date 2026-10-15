<?php
require 'config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid file ID.'); }
$stmt = $pdo->prepare('SELECT * FROM student_files WHERE id = ?'); $stmt->execute([$id]); $file = $stmt->fetch();
if (!$file) { http_response_code(404); exit('File not found.'); }
$path = UPLOAD_DIR . basename($file['stored_name']);
if (!is_file($path)) { http_response_code(404); exit('Stored file is missing.'); }
$inline = str_starts_with($file['file_type'], 'image/');
header('X-Content-Type-Options: nosniff');
header('Content-Type: ' . $file['file_type']);
header('Content-Length: ' . filesize($path));
header('Content-Disposition: ' . ($inline ? 'inline' : 'attachment') . '; filename="' . rawurlencode($file['original_name']) . '"');
readfile($path);
exit;
