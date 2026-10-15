<?php
function saveUploadedFiles(PDO $pdo, int $studentId, array $fileBag): array {
    global $allowedMimeTypes;
    $errors = [];
    if (!isset($fileBag['name']) || !is_array($fileBag['name'])) return $errors;

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    for ($i = 0; $i < count($fileBag['name']); $i++) {
        if ($fileBag['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
        if ($fileBag['error'][$i] !== UPLOAD_ERR_OK) { $errors[] = 'A file upload failed.'; continue; }
        if ($fileBag['size'][$i] > MAX_FILE_SIZE) { $errors[] = $fileBag['name'][$i] . ' exceeds 5 MB.'; continue; }

        $tmp = $fileBag['tmp_name'][$i];
        $mime = $finfo->file($tmp);
        if (!isset($allowedMimeTypes[$mime])) { $errors[] = $fileBag['name'][$i] . ' has an unsupported file type.'; continue; }

        $original = basename($fileBag['name'][$i]);
        $extension = $allowedMimeTypes[$mime];
        $stored = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = UPLOAD_DIR . $stored;

        if (!move_uploaded_file($tmp, $destination)) { $errors[] = 'Could not save ' . $original . '.'; continue; }
        $relativePath = 'uploads/' . $stored;
        try {
            $stmt = $pdo->prepare('INSERT INTO student_files (student_id, original_name, stored_name, file_path, file_type, file_size) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$studentId, $original, $stored, $relativePath, $mime, (int)$fileBag['size'][$i]]);
        } catch (Throwable $e) {
            if (is_file($destination)) unlink($destination);
            $errors[] = 'Could not save file metadata for ' . $original . '.';
        }
    }
    return $errors;
}
