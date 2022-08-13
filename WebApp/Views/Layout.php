<!DOCTYPE html>
<html>
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Classes/Class.Main.php'); ?>

  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Meta.php'); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/CSS.php'); ?>

  <title>Spotify Radio</title>  
</head>
<body class="bg-dark text-primary">

<div class="overlay hidden" id="loader-overlay">
  <div class="overlay-content">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</div>

<div class="container mt-2">
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Header.php'); ?>
  <div class="mt-3 p-0">
    <main id="RenderBody"></main>
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Footer.php'); ?>
</div>
</body>
</html>
