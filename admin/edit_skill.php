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
    $category = trim($_POST['category']);
    $skill_name = trim($_POST['skill_name']);
    $proficiency = intval($_POST['proficiency']);
    $eid=$_GET['editid'];

    $sql = "UPDATE skills SET category=:category, skill_name=:skill_name, proficiency=:proficiency WHERE ID=:eid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':category', $category,PDO::PARAM_STR);
    $query->bindParam(':skill_name', $skill_name,PDO::PARAM_STR);
    $query->bindParam(':proficiency', $proficiency,PDO::PARAM_STR);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);

    $query->execute();
        echo '<script>alert("Skill has been updated")</script>';
        echo "<script>window.location.href = 'manage_skills.php'</script>";    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : Skill Update</title>
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
                                <h1>Skill</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Skill</li>
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
                                    <h4>Update Skill</h4>
                                    <form method="post" name="hjhgh">
                                        <?php
                                            $eid=$_GET['editid'];
                                            $sql="SELECT * from skills where ID=$eid";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);

                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $row)
                                            {               
                                        ?>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" class="form-control border-none input-flat bg-ash" required="true">
                                                    <option value="ERP Packages" <?php if ($row->category == "ERP Packages") echo "selected"; ?>>ERP Packages</option>
                                                    <option value="BI Tools" <?php if ($row->category == "BI Tools") echo "selected"; ?>>BI Tools</option>
                                                    <option value="Big Data Platforms" <?php if ($row->category == "Big Data Platforms") echo "selected"; ?>>Big Data Platforms</option>
                                                    <option value="Databases" <?php if ($row->category == "Databases") echo "selected"; ?>>Databases</option>
                                                    <option value="Development Environment" <?php if ($row->category == "Development Environment") echo "selected"; ?>>Development Environment</option>
                                                    <option value="Embedded Platform" <?php if ($row->category == "Embedded Platform") echo "selected"; ?>>Embedded Platform</option>
                                                </select>
                                            </div>
                                        </div>                                      

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Skill Name</label>
                                                <input type="text" name="skill_name" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->skill_name);?>" required="true">
                                            </div>
                                        </div>  
                                        
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Proficiency (%)</label>
                                                <input type="number" name="proficiency" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->proficiency);?>" min="0" max="100" required="true">
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