<?php
require 'config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid student ID.'); }
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?'); $stmt->execute([$id]); $student = $stmt->fetch();
if (!$student) { http_response_code(404); exit('Student not found.'); }
$filesStmt = $pdo->prepare('SELECT * FROM student_files WHERE student_id = ? ORDER BY uploaded_at DESC');
$filesStmt->execute([$id]); $files = $filesStmt->fetchAll();
$pageTitle = 'Student details';
require 'header.php';
?>
<h1><?= e($student['name']) ?></h1>
<?php if (isset($_GET['saved'])): ?><div class="notice">Changes saved.</div><?php endif; ?>
<div class="panel">
  <p><strong>Roll number:</strong> <?= e($student['roll_number']) ?></p>
  <p><strong>Email:</strong> <?= e($student['email']) ?></p>
  <p><strong>Course:</strong> <?= e($student['course']) ?></p>
  <p><strong>Created:</strong> <?= e($student['created_at']) ?></p>
  <h2>Uploaded files</h2>
  <?php if (!$files): ?><p>No files uploaded.</p><?php else: ?>
    <table><thead><tr><th>File</th><th>Type</th><th>Size</th><th>Upload date</th></tr></thead><tbody>
    <?php foreach ($files as $file): ?><tr>
      <td><a href="download.php?id=<?= (int)$file['id'] ?>" target="_blank" rel="noopener"><?= e($file['original_name']) ?></a></td>
      <td><?= e($file['file_type']) ?></td><td><?= number_format($file['file_size']/1024, 1) ?> KB</td><td><?= e($file['uploaded_at']) ?></td>
    </tr><?php endforeach; ?>
    </tbody></table>
  <?php endif; ?>
  <p><a class="btn" href="edit.php?id=<?= (int)$id ?>">Edit student</a> <a class="btn secondary" href="index.php">Back</a></p>
</div>
<?php require 'footer.php'; ?>
