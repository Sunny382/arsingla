<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['tsasaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $tsasaid = $_SESSION['tsasaid'];
        $cid = $_POST['cid'];
        $cc_id = $_POST['cc_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $eid = $_GET['editid'];
        $existing_file = $_POST['existing_file']; // Hidden field storing old file path

        $upload_dir = "uploads/assignments/"; // File upload directory
        $file_path = $existing_file; // Default to existing file

        // Handle file upload
        if (!empty($_FILES["assignment_file"]["name"])) {
            $file_name = $_FILES["assignment_file"]["name"]; // Keep original file name
            $full_upload_path = $upload_dir . $file_name; // Full file path to save in DB

            // Move uploaded file (overwrite existing file with same name)
            if (move_uploaded_file($_FILES["assignment_file"]["tmp_name"], $full_upload_path)) {
                $file_path = $full_upload_path; // Save full path in DB

                // Delete the old file if exists (only if a new file with a different name is uploaded)
                if (!empty($existing_file) && $existing_file !== $full_upload_path && file_exists($existing_file)) {
                    unlink($existing_file);
                }
            }
        }

        // Update assignment details in the database
        $sql = "UPDATE assignments SET CourseID=:cid, course_category_id=:cc_id, title=:title, description=:description, file_path=:file_path WHERE id=:eid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_INT);
        $query->bindParam(':cc_id', $cc_id, PDO::PARAM_INT);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':file_path', $file_path, PDO::PARAM_STR); // Save full path
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);

        if ($query->execute()) {
            echo '<script>alert("Assignment has been updated successfully!");</script>';
            echo "<script>window.location.href = 'upload_assignment.php'</script>";
        } else {
            echo '<script>alert("Something went wrong. Please try again!");</script>';
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : Assignment Update</title>
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
                                <h1>Assignment</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
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
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <div id="main-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Update Assignment</h4>
                                    <form method="post" name="hjhgh" enctype="multipart/form-data">
                                        <?php
                                            $eid = $_GET['editid'];
                                            $sql = "SELECT * FROM assignments WHERE id = :eid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':eid', $eid, PDO::PARAM_INT);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                                    $selectedCourseID = $row->CourseID;
                                                    $selectedCourseCategoryID = $row->course_category_id; 
                                        ?>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Course Name</label>
                                                <select class="form-control border-none input-flat bg-ash" name="cid" id="courseSelect" required="true">
                                                    <option value="">Select Course</option>
                                                    <?php 
                                                        $sql = "SELECT * FROM tblcourse";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $course) {
                                                                $selected = ($course->ID == $selectedCourseID) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo htmlentities($course->ID); ?>" <?php echo $selected; ?>>
                                                            <?php echo htmlentities($course->CourseName); ?>
                                                        </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Select Course Category</label>
                                                <select class="form-control border-none input-flat bg-ash" name="cc_id" id="categorySelect" required="true">
                                                    <option value="">Select Course Category</option>
                                                    <?php 
                                                        $sql = "SELECT * FROM courses_categories WHERE course_id = :course_id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':course_id', $selectedCourseID, PDO::PARAM_INT);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $courseCategory) {
                                                                $selected = ($courseCategory->id == $selectedCourseCategoryID) ? 'selected' : ''; 
                                                    ?>
                                                        <option value="<?php echo htmlentities($courseCategory->id); ?>" <?php echo $selected; ?>>
                                                            <?php echo htmlentities($courseCategory->course_category); ?>
                                                        </option>
                                                    <?php 
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Assignment Title</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->title);?>" name="title" required="true">
                                            </div>
                                        </div>                                          
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control border-none input-flat bg-ash" name="description" required><?php  echo htmlentities($row->description);?></textarea>
                                            </div>
                                        </div> 
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Assignment File</label>
                                                <input type="file" class="form-control border-none input-flat bg-ash" name="assignment_file">
                                                <?php if (!empty($row->file_path)) { ?> 
                                                    <p>Current File: 
                                                        <a href="<?php echo htmlentities($row->file_path); ?>" target="_blank">View</a>
                                                    </p>
                                                    <input type="hidden" name="existing_file" value="<?php echo htmlentities($row->file_path); ?>">
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
</body>
</html><?php //}  ?>

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