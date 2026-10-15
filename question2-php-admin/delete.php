<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Use POST to delete a student.'); }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid student ID.'); }

// Remove stored files first, then delete the student (metadata is cascaded by MySQL).
$stmt = $pdo->prepare('SELECT stored_name FROM student_files WHERE student_id = ?');
$stmt->execute([$id]);
foreach ($stmt->fetchAll() as $file) {
    $path = UPLOAD_DIR . basename($file['stored_name']);
    if (is_file($path)) unlink($path);
}
$delete = $pdo->prepare('DELETE FROM students WHERE id = ?');
$delete->execute([$id]);
header('Location: index.php?deleted=1');
exit;
