<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['tsasaid']==0)) {
  header('location:logout.php');
} else{
    if(isset($_POST['submit']))
  {
    $tsasaid=$_SESSION['tsasaid'];
    $cid = $_POST['cid'];
    $course_category = $_POST['course_category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $eid=$_GET['editid'];

    $sql = "UPDATE courses_categories SET course_id=:cid, course_category=:course_category, title=:title, description=:description WHERE id=:eid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':cid', $cid, PDO::PARAM_INT);
    $query->bindParam(':course_category', $course_category, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);

    $query->execute();
        echo '<script>alert("Course Category has been updated")</script>';
        echo "<script>window.location.href = 'course_category.php'</script>";    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : Course Category Update</title>
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
                                <h1>Course Category</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Course Category</li>
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
                                    <h4>Update Course Category</h4>
                                    <form method="post" name="hjhgh">
                                        <?php
                                            $eid = $_GET['editid'];
                                            $sql = "SELECT * FROM courses_categories WHERE id = :eid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':eid', $eid, PDO::PARAM_INT);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                                    $selectedCourseID = $row->course_id; 
                                        ?>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Course Name</label>
                                                <select class="form-control border-none input-flat bg-ash" name="cid" required="true">
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
                                                    <label>Course Category</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->course_category);?>" name="course_category" required="true">
                                                </div>
                                            </div>
                                            <div class="basic-form m-t-20">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->title);?>" name="title" required="true">
                                                </div>
                                            </div>
                                            <div class="basic-form m-t-20">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->description);?>" name="description" required="true">
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
</html><?php }  ?>