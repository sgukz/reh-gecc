<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>ลงทะเบียนคำร้องขอเอกสาร - ศูนย์ราชการสะดวก โรงพยาบาลร้อยเอ็ด</title>
  <!-- MDB icon -->
  <link rel="icon" href="src/assets/img/logo.png" type="image/x-icon">
  <link rel="shortcut icon" href="src/assets/img/logo.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Google Fonts Roboto -->
  <link href="https://fonts.googleapis.com/css?family=Kanit:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="src/assets/css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="src/assets/css/mdb.min.css">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="src/assets/css/style.css">
  <link rel="stylesheet" href="src/assets/css/timeline.css">
</head>

<body class="flyout blue lighten-5">
  <?php
  date_default_timezone_set('Asia/Bangkok');
  include 'src/models/_config_db.php';
  include 'src/models/PatientModel.php';
  include 'src/functions/DateTime.php';
  $patient = new Patients();
  ?>
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark  blue lighten-1">

    <!-- Navbar brand -->
    <a class="navbar-brand font-weight-bold" href="#">
      <img src="src/assets/img/logo.png" width="40" alt="ศูนย์ราชการสะดวก GECC"> ศูนย์ราชการสะดวก GECC
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

      <!-- Links -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?=isset($_GET["page"]) ? "" : "active"?>">
          <a class="nav-link" href="index.php">ลงทะเบียนคำร้อง
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item <?=isset($_GET["page"]) ? "active" : ""?>">
          <a class="nav-link" href="index.php?page=check">ตรวจสอบสถานะคำร้อง</a>
        </li>
    </div>
    <!-- Collapsible content -->

  </nav>
  <!--/.Navbar-->
  <?php
  if(isset($_GET["page"])){
    include 'src/pages/check.php';
  }else{
    include 'src/pages/register.php';
  }
  ?>

  
  <!-- jQuery -->
  <script type="text/javascript" src="src/assets/js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="src/assets/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="src/assets/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="src/assets/js/mdb.min.js"></script>
  <script type="text/javascript" src="src/assets/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="src/assets/js/sweetalert2.js"></script>
  <script type="text/javascript" src="src/functions/DateTimeThai.js"></script>
  <script type="text/javascript" src="src/ajax/register.js"></script>
  <script type="text/javascript" src="src/ajax/check.js"></script>
  <!-- Your custom scripts (optional) -->

</body>

</html>