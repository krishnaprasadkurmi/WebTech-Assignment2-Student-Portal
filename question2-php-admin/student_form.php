<?php
// Shared form used by create.php and edit.php.
?>
<form class="panel" method="post" enctype="multipart/form-data">
  <label>Full name *
    <input name="name" required maxlength="120" value="<?= e($student['name'] ?? '') ?>">
  </label>
  <label>Roll number *
    <input name="roll_number" required maxlength="40" value="<?= e($student['roll_number'] ?? '') ?>">
  </label>
  <label>Email *
    <input name="email" type="email" required maxlength="160" value="<?= e($student['email'] ?? '') ?>">
  </label>
  <label>Course *
    <select name="course" required>
      <option value="">Select course</option>
      <?php foreach (['Computer Science and Engineering','Information Technology','Electronics and Communication Engineering','Electrical and Electronics Engineering','Mechanical Engineering'] as $course): ?>
      <option value="<?= e($course) ?>" <?= (($student['course'] ?? '') === $course) ? 'selected' : '' ?>><?= e($course) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Profile image / ID proof / certificate (optional; max 5 MB each)
    <input type="file" name="files[]" multiple accept=".jpg,.jpeg,.png,.pdf">
  </label>
  <p class="muted">Allowed types: JPG, PNG, PDF. Existing files are not overwritten; each upload gets a unique stored filename.</p>
  <button class="btn" type="submit"><?= e($submitLabel) ?></button>
  <a class="btn secondary" href="index.php">Cancel</a>
</form>
