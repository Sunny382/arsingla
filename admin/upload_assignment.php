<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/dbconnection.php');

if (strlen($_SESSION['tsasaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $tsasaid = $_SESSION['tsasaid'];
        $cid = $_POST['cid'];
        $cc_id = $_POST['cc_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        // File upload handling
        $file_name = $_FILES["assignment_file"]["name"];
        $file_tmp = $_FILES["assignment_file"]["tmp_name"];
        $upload_dir = "uploads/assignments/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if not exists
        }

        $file_path = $upload_dir . basename($file_name);

        // Check file upload errors
        if ($_FILES['assignment_file']['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('File upload error: " . $_FILES['assignment_file']['error'] . "');</script>";
        } elseif (move_uploaded_file($file_tmp, $file_path)) {
            // Insert into database
            $sql = "INSERT INTO assignments (CourseID, course_category_id, title, description, file_path) 
                    VALUES (:cid, :cc_id, :title, :description, :file_path)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':cid', $cid, PDO::PARAM_INT);
            $query->bindParam(':cc_id', $cc_id, PDO::PARAM_INT);
            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':file_path', $file_path, PDO::PARAM_STR);

            if ($query->execute()) {
                echo '<script>alert("Assignment uploaded successfully!");</script>';
                echo "<script>window.location.href ='upload_assignment.php'</script>";
            } else {
                $errorInfo = $query->errorInfo();
                echo '<script>alert("Database Error: ' . $errorInfo[2] . '");</script>';
            }
        } else {
            echo '<script>alert("File upload failed!");</script>';
        }
    }

    // Delete assignment logic
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM assignments WHERE id = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);
        if ($query->execute()) {
            echo "<script>alert('Assignment deleted successfully!');</script>";
            echo "<script>window.location.href = 'upload_assignment.php'</script>";
        } else {
            $errorInfo = $query->errorInfo();
            echo '<script>alert("Delete Error: ' . $errorInfo[2] . '");</script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>TSAS : Assignment Create</title>
    <link href="../assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/lib/unix.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
    /* Styling the View Attachment Button */

    /* Styling the Download Link */
    .download-link {
        color: #007bff; /* Blue text */
        text-decoration: underline; /* Underline link */
        font-size: 14px;
        font-weight: bold;
        margin-left: 10px; /* Space between button and link */
    }

    .download-link:hover {
        color: #0056b3; /* Darker blue on hover */
    }
</style>

</head>
<body>
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Assignment</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Assignment</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="main-content">
                    <div class="row">
                        <!-- Upload Assignment Form -->
                        <div class="col-md-4">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Create A New Assignment</h4>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Select Course</label>
                                                <select class="form-control border-none input-flat bg-ash" name="cid" id="courseSelect" required="true">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                        $sql="SELECT * from tblcourse";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                                        $cnt=1;
                                                        if($query->rowCount() > 0)
                                                        {
                                                        foreach($results as $row)
                                                        {
                                                    ?>
                                                    <option value="<?php  echo htmlentities($row->ID);?>"><?php  echo htmlentities($row->CourseName);?></option><?php $cnt=$cnt+1;}} ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Select Course Category</label>
                                                <select class="form-control border-none input-flat bg-ash" name="cc_id" id="categorySelect" required="true">
                                                    <option value="">Select Course Category</option>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Assignment Title</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" name="title" placeholder="Assignment Title" required>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control border-none input-flat bg-ash" name="description" placeholder="Assignment Description" required></textarea>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Assignment File</label>
                                                <input type="file" class="form-control border-none input-flat bg-ash" name="assignment_file" required>
                                            </div>
                                        </div>

                                        <button class="btn btn-warning btn-lg m-b-10" type="submit" name="submit">Upload</button>
                                        <button class="btn btn-default btn-lg m-b-10" type="reset">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Display Assignments -->
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>ALL Assignments</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Course Name</th>
                                                    <th>Course Category</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT a.*, c.CourseName, cat.course_category 
                                                    FROM assignments a
                                                    JOIN tblcourse c ON a.CourseID  = c.ID
                                                    JOIN courses_categories cat ON a.course_category_id = cat.id
                                                    ORDER BY a.uploaded_at DESC";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;

                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->CourseName); ?></td>
                                                    <td><?php echo htmlentities($row->course_category); ?></td>
                                                    <td><?php echo htmlentities($row->title); ?></td>
                                                    <td><?php echo htmlentities($row->description); ?></td>
                                                    <td>
                                                        <button class='view-attachment-btn' data-attachment="<?php echo htmlentities($row->file_path); ?>">
                                                            View Attachment
                                                        </button>
                                                        <a href="<?php echo htmlentities($row->file_path); ?>" download class="download-link">
                                                            ⬇️ Download
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span><a href="edit_assignment.php?editid=<?php echo htmlentities($row->id); ?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="upload_assignment.php?delid=<?php echo ($row->id); ?>" onclick="return confirm('Do you really want to Delete?');"><i class="ti-trash color-danger"></i></a></span>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include_once('includes/footer.php'); ?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".view-attachment-btn").forEach(button => {
            button.addEventListener("click", function () {
                let filePath = this.getAttribute("data-attachment");
                window.open(filePath, "_blank"); // Opens file in a new tab
            });
        });
    });


    $(document).ready(function(){
        $('#courseSelect').change(function(){
            var course_id = $(this).val();
            if (course_id === '') {
                $('#categorySelect').html('<option value="">Select Course Category</option>');
                return;
            }
            $.ajax({
                url: 'fetch_categories.php',
                type: 'POST',
                data: { course_id: course_id },
                success: function(response) {
                    $('#categorySelect').html(response);
                }
            });
        });
    });
</script>
</body>
</html>
