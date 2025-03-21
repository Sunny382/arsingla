<?php
include ('header.php');
session_start();
include('admin/includes/dbconnection.php'); 
if (isset($_GET['course_id']) && isset($_GET['category_id'])) {
    $course_id = $_GET['course_id'];
    $category_id = $_GET['category_id'];

    // Get category name
    $sql = "SELECT course_category FROM courses_categories WHERE id = :category_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $query->execute();
    $category = $query->fetch(PDO::FETCH_OBJ);

    // Fetch assignments (files)
    $sql = "SELECT * FROM assignments WHERE CourseID = :course_id AND course_category_id = :category_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $query->execute();
    $assignments = $query->fetchAll(PDO::FETCH_OBJ);
} else {
    die("Invalid Request");
}
?>
        <main class="main">
            <!-- Page Title -->
            <div class="page-title dark-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Downloads for Files: <?php echo htmlspecialchars($category->course_category); ?></h1>
                <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li class="current"><?php echo htmlspecialchars($category->course_category); ?></li>
                </ol>
                </nav>
            </div>
            </div><!-- End Page Title -->

            <!-- Downloads for Category -->
            <section id="courses-details" class="courses-details section py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-primary text-white text-center">
                                    <h4 class="mb-0">📂 Course Materials</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (count($assignments) > 0) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $cnt = 1; foreach ($assignments as $row) { ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->title); ?></td>
                                                            <td><?php echo htmlentities($row->description); ?></td>
                                                            <td>
                                                                <a href="<?php echo 'admin/' . htmlentities($row->file_path); ?>" download class="btn btn-sm btn-success download-btn">
                                                                    ⬇️ Download
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php $cnt++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-warning text-center">
                                            <p>No files available for this category.</p>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer text-center">                               
                                    <a href="categories.php?course_id=<?php echo $course_id; ?>" class="btn btn-secondary">
                                        🔙 Back to Categories
                                    </a>
                                    <?php if (isset($_SESSION['user_id'])) { ?>
                                        <a href="logout.php" class="btn btn-danger">Logout</a>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".download-btn");

    buttons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Default behavior roke
            
            const fileUrl = this.getAttribute("href");
            const course_id = new URLSearchParams(window.location.search).get("course_id");
            const category_id = new URLSearchParams(window.location.search).get("category_id");

            fetch("check_login.php")
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = fileUrl;
                    } else {
                        window.location.href = `login.php?redirect=download.php&course_id=${course_id}&category_id=${category_id}`;
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
});

</script>
