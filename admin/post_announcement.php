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
        $tsasaid=$_SESSION['tsasaid'];
        $title=$_POST['title'];
        $message=$_POST['message'];
        $expiry_date=$_POST['expiry_date'];

        $sql="insert into announcements(title, message, expiry_date)values(:title,:message,:expiry_date)";
        $query=$dbh->prepare($sql);
        $query->bindParam(':title',$title,PDO::PARAM_STR);
        $query->bindParam(':message',$message,PDO::PARAM_STR);
        $query->bindParam(':expiry_date',$expiry_date,PDO::PARAM_STR);

        $query->execute();
        $LastInsertId=$dbh->lastInsertId();
        if ($LastInsertId>0) {
        echo '<script>alert("Announcement Posted!")</script>';
        echo "<script>window.location.href ='post_announcement.php'</script>";
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
        $sql="delete from announcements where ID=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>"; 
        echo "<script>window.location.href = 'post_announcement.php'</script>";     
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>   
    <title>TSAS : Announcements Create</title>
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
                                <h1>Post Announcements </h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Announcements</li>
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
                                    <h4>Create A New Announcements</h4>
                                    <form method="post" name="hjhgh">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Announcement Title</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Announcement Title" name="title" required="true">
                                            </div>
                                        </div>                                      

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Announcement Message</label>
                                                <textarea class="form-control border-none input-flat bg-ash" placeholder="Announcement Message" name="message" required="true"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Expiry Date</label>
                                                <input type="date" class="form-control border-none input-flat bg-ash" placeholder="Expiry Date" name="expiry_date" required="true">
                                            </div>
                                        </div> 
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Post Announcement</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>ALL Announcement</h4>                                                                  
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Title</th>
                                                    <th>Message</th>
                                                    <th>Created Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * FROM announcements ORDER BY created_at DESC";
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
                                                        <?php  echo htmlentities($row->title);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->message);?>
                                                    </td>                           
                                                    <td>
                                                        <?php echo date("d-m-Y", strtotime($row->created_at)); ?>
                                                    </td>   
                                                    <td>
                                                        <?php echo date("d-m-Y", strtotime($row->expiry_date)); ?>
                                                    </td>                                             
                                                    <td>                                                      
                                                        <span><a href="edit_announcements.php?editid=<?php echo htmlentities ($row->ID);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="post_announcement.php?delid=<?php echo ($row->ID);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
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
</body>
</html><?php }  ?>