<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['tsasaid']==0)) {
  header('location:logout.php');
} 
else
{
    if(isset($_POST['submit']))
    {
        $ocasaid=$_SESSION['tsasaid'];
        $cid=$_POST['cid'];
        $cc=$_POST['course_category'];
        $cct=$_POST['title'];
        $ccd=$_POST['description'];

        $sql="insert into courses_categories(course_id,course_category,title,description)values(:cid,:cc,:cct,:ccd)";
        $query=$dbh->prepare($sql);
        $query->bindParam(':cid',$cid,PDO::PARAM_STR);
        $query->bindParam(':cc',$cc,PDO::PARAM_STR);
        $query->bindParam(':cct',$cct,PDO::PARAM_STR);
        $query->bindParam(':ccd',$ccd,PDO::PARAM_STR);
        $query->execute();

        $LastInsertId=$dbh->lastInsertId();
        if ($LastInsertId>0) {
            echo '<script>alert("Course Category has been added.")</script>';
            echo "<script>window.location.href ='course_category.php'</script>";
        }
        else
        {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
 
    }
    // Code for deleting product from cart
    if(isset($_GET['delid']))
    {
        $rid=intval($_GET['delid']);
        $sql="delete from courses_categories where id=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>"; 
        echo "<script>window.location.href = 'course_category.php'</script>";     
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>   
        <title>OCAS : Course Category</title>
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
                            <div class="col-md-4">
                                <div class="card alert">
                                    <div class="card-header pr">
                                        <h4>Create A New Course Category</h4>
                                        <form method="post" name="hjhgh">
                                            <div class="basic-form m-t-20">
                                                <div class="form-group">
                                                    <label>Course Name</label>
                                                    <select class="form-control border-none input-flat bg-ash" name="cid" required="true">
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
                                                    <label>Course Category</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Course Category" name="course_category" required="true">
                                                </div>
                                            </div>
                                            <div class="basic-form m-t-20">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Title" name="title" required="true">
                                                </div>
                                            </div>
                                            <div class="basic-form m-t-20">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Description" name="description" required="true">
                                                </div>
                                            </div>
                                        
                                            <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Save</button>
                                            <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card alert">
                                    <div class="card-header pr">
                                        <h4>ALL Course Category</h4>                                                
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT c.CourseName, cc.id, cc.course_category, cc.title, cc.description
                                                        FROM courses_categories cc
                                                        JOIN tblcourse c ON cc.course_id = c.ID";
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
                                                            <?php  echo htmlentities($row->CourseName);?>
                                                        </td>
                                                        <td>
                                                            <?php  echo htmlentities($row->course_category);?>
                                                        </td>
                                                        <td>
                                                            <?php  echo htmlentities($row->title);?>
                                                        </td>
                                                        <td>
                                                            <?php  echo htmlentities($row->description);?>
                                                        </td>
                                                        <td>                                                       
                                                            <span><a href="edit_course_category.php?editid=<?php echo htmlentities ($row->id);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                            <span><a href="course_category.php?delid=<?php echo ($row->id);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt=$cnt+1;}} ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </body>
</html><?php }  ?>