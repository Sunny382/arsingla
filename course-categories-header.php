<?php
// Current file ka naam fetch karega
$pageName = basename($_SERVER['PHP_SELF'], ".php");

// Page Title Mapping
$pageTitles = [
    "index" => "Home",
    "about" => "About Us",
    "services" => "Our Services",
    "gallery" => "Gallery",
    "contact" => "Contact Us",
    "courses" => "Course Categories"
];

// Default title agar page mapping me na ho
$title = isset($pageTitles[$pageName]) ? $pageTitles[$pageName] . " | Dr. Ashim Raj Singla" : "Dr. Ashim Raj Singla";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"> 
  <title><?php echo $title; ?></title> 
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="192x192" href="assets/img/drsingla1.png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="service-details-page">

  <header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle d-xl-none bi bi-list"></i>
    <div class="profile-img">
      <img src="assets/img/img3.jpg" alt="" class="img-fluid rounded-circle">
    </div>

    <a href="index.php" class="logo d-flex align-items-center justify-content-center">
      <h1 class="sitename">Dr. Ashim Raj Singla</h1>
    </a>

    <div class="social-links text-center">
      <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
    </div>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="index.php" class="active"><i class="bi bi-house navicon"></i>Home</a></li>
      </ul>
    </nav>
  </header>
