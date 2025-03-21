<?php
include ('header.php');
include('admin/includes/dbconnection.php'); 

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($book_id > 0) {
    $sql = "SELECT * FROM books WHERE id = :book_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $query->execute();
    $book = $query->fetch(PDO::FETCH_OBJ);
    if (!$book) {
        echo "<script>alert('Book not found!'); window.location.href = 'index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid Book ID'); window.location.href = 'index.php';</script>";
    exit;
}
?>

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0"><?php echo htmlspecialchars($book->title); ?></h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li class="current"><?php echo htmlspecialchars($book->title); ?></li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="book-details" class="book-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <!-- Book Image (Small + Click for Popup) -->
                <div class="col-lg-5">
                    <a href="admin/uploads/books/<?php echo htmlspecialchars($book->book_image); ?>" class="book-popup" target="_blank">
                        <img src="admin/uploads/books/<?php echo htmlspecialchars($book->book_image); ?>" class="img-fluid rounded shadow-sm book-thumbnail" alt="<?php echo htmlspecialchars($book->title); ?>">
                    </a>
                </div>

                <!-- Book Details Section -->
                <div class="col-lg-7">
                    <div class="book-info p-4 border rounded shadow-sm" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-primary mb-3">Book Information</h3>
                        <ul class="list-unstyled">
                            <li><strong>📖 Title</strong>: <?php echo htmlspecialchars($book->title); ?></li>
                            <li><strong>✍ Author</strong>: <?php echo htmlspecialchars($book->author); ?></li>
                            <li><strong>📅 Published Year</strong>: <?php echo ($book->published_year) ? $book->published_year : 'N/A'; ?></li>
                            <li><strong>📌 Uploaded On</strong>: <?php echo date("d M, Y", strtotime($book->created_at)); ?></li>
                        </ul>
                    </div>
                    <div class="book-description mt-4 p-4 border rounded shadow-sm bg-light" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-dark">Description</h2>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($book->description)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Book Details Section -->
</main>

<!-- Add Magnific Popup for Image Lightbox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).ready(function() {
        $('.book-popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            gallery: {
                enabled: false
            },
            image: {
                verticalFit: true
            }
        });
    });
</script>

<style>
    /*  Image Styling */
    .book-thumbnail {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
    }
    .book-thumbnail:hover {
        transform: scale(1.05);
    }

    /*  Book Info Box */
    .book-info ul li {
        font-size: 16px;
        padding: 5px 0;
    }

    /*  Make Popup Image Bigger */
    .mfp-img {
        max-width: 90%;
        height: auto;
    }
</style>

<?php include ('footer.php'); ?>
