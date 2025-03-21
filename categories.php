<?php
include ('header.php');
include('admin/includes/dbconnection.php'); 

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Get course name
    $sql = "SELECT course_code, CourseName FROM tblcourse WHERE ID = :course_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $query->execute();
    $course = $query->fetch(PDO::FETCH_OBJ);

    // Fetch categories linked to this course
    $sql = "SELECT * FROM courses_categories WHERE course_id = :course_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $query->execute();
    $categories = $query->fetchAll(PDO::FETCH_OBJ);
} else {
    die("Invalid Course ID");
}
?>

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Categories for <?php echo htmlspecialchars($course->course_code); ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current"><?php echo htmlspecialchars($course->CourseName); ?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Categories Details Section -->
    <section id="courses-details" class="courses-details section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Course Categories List -->
                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body">
                            <h4 class="text-primary fw-bold mb-3 text-center">Course Categories</h4>
                            <?php if (!empty($categories)) { ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($categories as $category) { ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="downloads.php?course_id=<?php echo $course_id; ?>&category_id=<?php echo $category->id; ?>" 
                                            class="text-decoration-none text-dark fw-bold" target="_blank">
                                                <?php echo htmlspecialchars($category->course_category); ?>
                                            </a>
                                            <i class="bi bi-arrow-right-circle text-primary"></i>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <p class="text-muted text-center">No categories found.</p>
                            <?php } ?>
                            <a href="index.php" class="btn btn-outline-primary w-100 mt-3">🔙 Back to Courses</a>
                        </div>
                    </div>
                </div>

                <!-- Course Details -->
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body">
                            <?php if (!empty($categories)) { ?>
                                <h4 class="text-primary fw-bold"><?php echo htmlentities($categories[0]->title); ?></h4>
                                <p class="text-muted"><?php echo htmlentities($categories[0]->description); ?></p>
                            <?php } else { ?>
                                <p class="text-muted text-center">No course details available.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include ('footer.php');
?>

