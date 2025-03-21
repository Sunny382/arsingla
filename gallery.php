<?php
include ('header.php');
$folder = "assets/img/gallery/"; 
$images = array_diff(scandir($folder), array('.', '..')); 
?>

<style>
    .gallery-img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}
.gallery-img:hover {
    transform: scale(1.05);
}
</style>

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Gallery</h1>
            <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Gallery</li>
            </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container mt-5">
        <h2 class="text-center mb-4">📸 Gallery</h2>
        <div class="row">
            <?php foreach ($images as $image): ?>
                <?php if (in_array(strtolower(pathinfo($image, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="<?php echo $folder . $image; ?>" class="glightbox" data-gallery="gallery">
                            <img src="<?php echo $folder . $image; ?>" class="gallery-img img-fluid shadow">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>   
</main>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>
  
<?php
include ('footer.php');
?>