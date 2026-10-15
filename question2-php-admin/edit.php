<?php
require 'config.php';
require 'upload_helper.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid student ID.'); }
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?'); $stmt->execute([$id]); $student = $stmt->fetch();
if (!$student) { http_response_code(404); exit('Student not found.'); }
$pageTitle = 'Edit student';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student['name'] = trim($_POST['name'] ?? '');
    $student['roll_number'] = trim($_POST['roll_number'] ?? '');
    $student['email'] = trim($_POST['email'] ?? '');
    $student['course'] = trim($_POST['course'] ?? '');
    if (in_array('', [$student['name'],$student['roll_number'],$student['email'],$student['course']], true)) $errors[] = 'All student fields are required.';
    if (!filter_var($student['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!$errors) {
        try {
            $update = $pdo->prepare('UPDATE students SET name=?, roll_number=?, email=?, course=? WHERE id=?');
            $update->execute([$student['name'],$student['roll_number'],$student['email'],$student['course'],$id]);
            if (isset($_FILES['files'])) $errors = saveUploadedFiles($pdo, (int)$id, $_FILES['files']);
            if (!$errors) { header('Location: view.php?id=' . $id . '&saved=1'); exit; }
        } catch (PDOException $e) {
            $errors[] = ($e->getCode() === '23000') ? 'That roll number is already used by another student.' : 'Could not update the record.';
        }
    }
}
require 'header.php';
?>
<h1>Edit student</h1>
<?php foreach ($errors as $error): ?><div class="error"><?= e($error) ?></div><?php endforeach; ?>
<?php $submitLabel = 'Update student'; require 'student_form.php'; ?>
<?php require 'footer.php'; ?>
