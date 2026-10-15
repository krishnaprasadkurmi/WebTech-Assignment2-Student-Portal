<?php
require 'config.php';
$pageTitle = 'Student Records';
$students = $pdo->query('SELECT * FROM students ORDER BY id DESC')->fetchAll();
require 'header.php';
?>
<h1>Student records</h1>
<p class="muted">View, add, edit, and remove student records and uploaded files.</p>
<?php if (isset($_GET['saved'])): ?><div class="notice">Student record saved successfully.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="notice">Student record deleted successfully.</div><?php endif; ?>
<div class="panel">
  <p><a class="btn" href="create.php">+ Add student</a></p>
  <?php if (!$students): ?><p>No students yet. Add your first record.</p><?php else: ?>
  <table>
    <thead><tr><th>Name / Roll No.</th><th>Email</th><th>Course</th><th>Files</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($students as $student):
      $stmt = $pdo->prepare('SELECT * FROM student_files WHERE student_id = ? ORDER BY uploaded_at DESC');
      $stmt->execute([$student['id']]); $files = $stmt->fetchAll();
    ?>
      <tr>
        <td><strong><?= e($student['name']) ?></strong><br><?= e($student['roll_number']) ?></td>
        <td><?= e($student['email']) ?></td><td><?= e($student['course']) ?></td>
        <td><?php foreach ($files as $file): ?>
          <a class="filelink" target="_blank" rel="noopener" href="download.php?id=<?= (int)$file['id'] ?>"><?= e($file['original_name']) ?></a><br>
        <?php endforeach; if (!$files) echo 'No files'; ?></td>
        <td><div class="actions">
          <a class="btn secondary" href="view.php?id=<?= (int)$student['id'] ?>">View</a>
          <a class="btn secondary" href="edit.php?id=<?= (int)$student['id'] ?>">Edit</a>
          <form method="post" action="delete.php" onsubmit="return confirm('Delete this student and all linked file metadata?');">
            <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
            <button class="btn danger" type="submit">Delete</button>
          </form>
        </div></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require 'footer.php'; ?>
