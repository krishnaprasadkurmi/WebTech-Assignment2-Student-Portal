<?php if (!isset($pageTitle)) $pageTitle = 'Student Admin'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="index.php">Student<span>Portal</span></a>
  <nav><a href="index.php">Students</a><a href="create.php">Add student</a></nav>
</header>
<main class="container">
