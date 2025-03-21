<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['tsasaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $tsasaid = $_SESSION['tsasaid'];

        $title = $_POST['title'];
        $author = $_POST['author'];
        $published_year = $_POST['published_year'];
        $description = $_POST['description'];
        $eid = $_GET['editid'];
        $existing_file = $_POST['existing_file']; // Hidden field storing old file path

        $upload_dir = "uploads/books/"; // File upload directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $book_image = $existing_file; // Default to existing file

        // Handle file upload
        if (!empty($_FILES["book_image"]["name"])) {
            $file_name = $_FILES["book_image"]["name"]; // Keep original file name
            $file_tmp = $_FILES["book_image"]["tmp_name"];
            $full_upload_path = $upload_dir . $file_name; // Full file path to save in DB

            // Move uploaded file (overwrite existing file with same name)
            if (move_uploaded_file($file_tmp, $full_upload_path)) {
                $book_image = $file_name; // Save full path in DB

                // Delete the old file if exists (only if a new file with a different name is uploaded)              
                if (!empty($existing_file) && file_exists($upload_dir . $existing_file)) {
                    unlink($upload_dir . $existing_file);
                }
            }
        }
        // Update assignment details in the database
        $sql = "UPDATE books SET title=:title, author=:author, published_year=:published_year, description=:description, book_image=:book_image WHERE ID=:eid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':published_year', $published_year, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':book_image', $book_image, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);

        if ($query->execute()) {
            echo '<script>alert("Book has been updated successfully!");</script>';
            echo "<script>window.location.href = 'manage_books.php'</script>";
        } else {
            echo '<script>alert("Something went wrong. Please try again!");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : Books Update</title>
    <!-- Styles -->
    <link href="../assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/lib/unix.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include_once('includes/sidebar.php');?>  
<?php include_once('includes/header.php');?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Books</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Books</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <div id="main-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Update Books</h4>
                                    <form method="post" name="hjhgh" enctype="multipart/form-data">
                                        <?php
                                            $eid = $_GET['editid'];
                                            $sql = "SELECT * FROM books WHERE ID = :eid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':eid', $eid, PDO::PARAM_INT);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                               
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $row)
                                            {                                                                
                                        ?>                                       
                                        
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Book Title</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->title);?>" name="title" required="true">
                                            </div>
                                        </div>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Author</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash"  value="<?php  echo htmlentities($row->author);?>" name="author" required="true">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Published Year</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash"  value="<?php  echo htmlentities($row->published_year);?>" name="published_year" required="true"  maxlength="4">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control border-none input-flat bg-ash" name="description" required="true"><?php  echo htmlentities($row->description);?></textarea>
                                            </div>
                                        </div>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Book Image</label>
                                                <input type="file" class="form-control border-none input-flat bg-ash" name="book_image" accept="image/*">
                                                <?php if (!empty($row->book_image)) { ?> 
                                                    <p>Current Book Image: 
                                                        <a href="uploads/books/<?php echo htmlentities($row->book_image); ?>" target="_blank">View</a>
                                                    </p>
                                                    <input type="hidden" name="existing_file" value="<?php echo htmlentities($row->book_image); ?>">
                                                <?php } ?>
                                            </div>
                                        </div>                                                                
                                        <?php $cnt=$cnt+1;}} ?> 
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Update</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <?php include_once('includes/footer.php');?>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/lib/jquery.min.js"></script>
    <script src="../assets/js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="../assets/js/lib/menubar/sidebar.js"></script>
    <script src="../assets/js/lib/preloader/pace.min.js"></script>
    <!-- sidebar -->
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- bootstrap -->
    <script src="../assets/js/scripts.js"></script>
    <!-- scripit init-->

    <script>
        $(function () {
                $("input[name='published_year']").on('input', function (e) {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });
            });
    </script>
</body>
</html>
