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
        
        $file_name = $_FILES["book_image"]["name"];
        $file_tmp = $_FILES["book_image"]["tmp_name"];
        $upload_dir = "uploads/books/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . basename($file_name);

        if (move_uploaded_file($file_tmp, $file_path)) {
            $sql = "INSERT INTO books (title, author, published_year, description, book_image) VALUES (:title, :author, :published_year, :description, :book_image)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':author', $author, PDO::PARAM_STR);
            $query->bindParam(':published_year', $published_year, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':book_image', $file_name, PDO::PARAM_STR);
            
            $query->execute();
            $LastInsertId=$dbh->lastInsertId();
            if ($LastInsertId>0) {
                echo '<script>alert("Book has been added.")</script>';
                echo "<script>window.location.href ='manage_books.php'</script>";
            }
            else
            {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        } else {
            echo '<script>alert("File upload failed!");</script>';
        }
    }

    // Code for deleting book
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        
        $sql = "SELECT book_image FROM books WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        
        if ($result) {
            $image_path = "uploads/books/" . $result->book_image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            
            $sql = "DELETE FROM books WHERE ID=:rid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rid', $rid, PDO::PARAM_INT);
            $query->execute();
            
            echo '<script>alert("Book deleted successfully."); window.location.href = "manage_books.php";</script>';
        } else {
            echo '<script>alert("Book not found.");</script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <title>TSAS : Books Create</title>
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
                        <div class="col-md-4">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Create A New Books</h4>
                                    <form method="post" name="hjhgh" enctype="multipart/form-data">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Book Title</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Book Title" name="title" required="true">
                                            </div>
                                        </div>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Author</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Author" name="author" required="true">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Published Year</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Published Year" name="published_year" required="true"  maxlength="4">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control border-none input-flat bg-ash" placeholder="Description" name="description" required="true"></textarea>
                                            </div>
                                        </div>
  
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Book Image</label>
                                                <input type="file" class="form-control border-none input-flat bg-ash" name="book_image" accept="image/*" required>
                                            </div>
                                       </div>                                                                  
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Add Book</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>ALL Books</h4>                                                                  
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Year</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * from books ORDER BY ID DESC";
                                                    $query = $dbh -> prepare($sql);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                                                    $cnt=1;
                                                    if($query->rowCount() > 0)
                                                    {
                                                    foreach($results as $row)
                                                    {              
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt);?></td>
                                                    <td>
                                                        <a href="uploads/books/<?php echo htmlentities($row->book_image); ?>" target="_blank">
                                                        <img src="uploads/books/<?php echo htmlentities($row->book_image); ?>" width="50" onerror="this.onerror=null; this.src='default.jpg';">
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->title);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->author);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->published_year);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->description);?>
                                                    </td>                                                   
                                                    <td>                                                       
                                                        <span><a href="edit_books.php?editid=<?php echo htmlentities ($row->ID);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="manage_books.php?delid=<?php echo ($row->ID);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
                                                    </td>
                                                </tr>
                                                 <?php $cnt=$cnt+1;}} ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->
                    <?php include_once('includes/footer.php');?>
                </div>
            </div>
        </div>
    </div>
    <!-- jquery vendor -->
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
</html><?php }  ?>