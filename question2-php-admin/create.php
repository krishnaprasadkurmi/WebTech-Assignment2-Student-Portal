<?php
require 'config.php';
require 'upload_helper.php';
$pageTitle = 'Add student';
$student = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = [
      'name' => trim($_POST['name'] ?? ''),
      'roll_number' => trim($_POST['roll_number'] ?? ''),
      'email' => trim($_POST['email'] ?? ''),
      'course' => trim($_POST['course'] ?? '')
    ];
    if (in_array('', $student, true)) $errors[] = 'All student fields are required.';
    if (!filter_var($student['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!$errors) {
        try {
            $stmt = $pdo->prepare('INSERT INTO students (name, roll_number, email, course) VALUES (?, ?, ?, ?)');
            $stmt->execute(array_values($student));
            $id = (int)$pdo->lastInsertId();
            if (isset($_FILES['files'])) $errors = saveUploadedFiles($pdo, $id, $_FILES['files']);
            if (!$errors) { header('Location: index.php?saved=1'); exit; }
        } catch (PDOException $e) {
            $errors[] = ($e->getCode() === '23000') ? 'That roll number already exists.' : 'Could not save the student record.';
        }
    }
}
require 'header.php';
?>
<h1>Add student</h1>
<?php foreach ($errors as $error): ?><div class="error"><?= e($error) ?></div><?php endforeach; ?>
<?php $submitLabel = 'Save student'; require 'student_form.php'; ?>
<?php require 'footer.php'; ?>
