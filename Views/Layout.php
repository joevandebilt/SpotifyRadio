<!DOCTYPE html>
<html>
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Classes/Class.Main.php'); ?>

  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Meta.php'); ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/CSS.php'); ?>

  <title>Spotify Radio</title>  
</head>
<body>
<div class="container mt-2 row">
  <div class="col-1 m-0 p-0">
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Header.php'); ?>
  </div>
  <div class="col-11 m-0 p-0">
    <main id="RenderBody"></main>
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Global/Footer.php'); ?>
</div>
</body>
</html>
