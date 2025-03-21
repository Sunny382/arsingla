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
        $category = trim($_POST['category']);
        $skill_name = trim($_POST['skill_name']);
        $proficiency = intval($_POST['proficiency']);

        if (!empty($category) && !empty($skill_name) && ($proficiency >= 0 && $proficiency <= 100)) {
            try {
                $sql = "INSERT INTO skills (category, skill_name, proficiency) VALUES (:category, :skill_name, :proficiency)";
                $query=$dbh->prepare($sql);
                $query->bindParam(':category', $category,PDO::PARAM_STR);
                $query->bindParam(':skill_name', $skill_name,PDO::PARAM_STR);
                $query->bindParam(':proficiency', $proficiency,PDO::PARAM_STR);

                $query->execute();
                $LastInsertId=$dbh->lastInsertId();
                if ($LastInsertId>0) {
                echo '<script>alert("Skill added successfully!")</script>';
                echo "<script>window.location.href ='manage_skills.php'</script>";
                }
                else
                {
                    echo '<script>alert("Something Went Wrong. Please try again")</script>';
                }
            }
            catch (PDOException $e) {
                echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
            }
        } else {
            echo '<script>alert("Please fill all fields correctly.");</script>';
        }

    }
    // Code for deleting product from cart
    if(isset($_GET['delid']))
    {
        $rid=intval($_GET['delid']);
        $sql="delete from skills where ID=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>"; 
        echo "<script>window.location.href = 'manage_skills.php'</script>";     
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>   
    <title>TSAS : Skill</title>
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
                                <h1>Add Skill </h1>
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
                        <div class="col-md-4">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Create A New Skill</h4>
                                    <form method="post" name="hjhgh">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" class="form-control border-none input-flat bg-ash" required="true">
                                                    <option value="">Select Category</option>
                                                    <option value="ERP Packages">ERP Packages</option>
                                                    <option value="BI Tools">BI Tools</option>
                                                    <option value="Big Data Platforms">Big Data Platforms</option>
                                                    <option value="Databases">Databases</option>
                                                    <option value="Development Environment">Development Environment</option>
                                                    <option value="Embedded Platform">Embedded Platform</option>
                                                </select>
                                            </div>
                                        </div>                                      

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Skill Name</label>
                                                <input type="text" name="skill_name" class="form-control border-none input-flat bg-ash" placeholder="Enter Skill Name" required="true">
                                            </div>
                                        </div>  
                                        
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Proficiency (%)</label>
                                                <input type="number" name="proficiency" class="form-control border-none input-flat bg-ash" min="0" max="100" placeholder="Enter Proficiency (0-100)" required="true">
                                            </div>
                                        </div> 
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Add Skill</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>All Skills</h4>                                                                  
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category</th>
                                                    <th>Skill Name</th>
                                                    <th>Proficiency</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * FROM skills ORDER BY category, proficiency DESC";
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
                                                        <?php  echo htmlentities($row->category);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->skill_name);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->proficiency);?>
                                                    </td>                                                
                                                    <td>                                                      
                                                        <span><a href="edit_skill.php?editid=<?php echo htmlentities ($row->id);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="manage_skills.php?delid=<?php echo ($row->id);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
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