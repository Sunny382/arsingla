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
        $username=$_POST['username'];
        $email=$_POST['email'];
        //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $password = $_POST['password'];
        $role=$_POST['role'];

        $sql="insert into users(username, email, password, role)values(:username, :email, :password, 'user')";
        $query=$dbh->prepare($sql);
        $query->bindParam(':username',$username,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);

        $query->execute();
        $LastInsertId=$dbh->lastInsertId();
        if ($LastInsertId>0) {
        echo '<script>alert("User created Successfully!")</script>';
        echo "<script>window.location.href ='user_create.php'</script>";
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
        $sql="delete from users where ID=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>"; 
        echo "<script>window.location.href = 'user_create.php'</script>";     
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>   
    <title>TSAS : User Create</title>
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
                                <h1>User Create</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">User Create</li>
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
                                    <h4>Create A New User</h4>
                                    <form method="post" name="hjhgh">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Username" name="username" required="true">
                                            </div>
                                        </div>                                      

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Email" name="email" required="true">
                                            </div>
                                        </div>
                                        
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control border-none input-flat bg-ash" placeholder="Password" name="password" required="true">
                                            </div>
                                        </div> 
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Create User</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>ALL User</h4>                                                                  
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Role</th>
                                                    <th>Created Date</th>                                                   
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * FROM users ORDER BY created_at DESC";
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
                                                        <?php  echo htmlentities($row->username);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->email);?>
                                                    </td> 
                                                    <td>
                                                        <?php echo htmlentities($row->password); ?>
                                                    </td>         
                                                    <td>
                                                        <?php echo htmlentities($row->role); ?>
                                                    </td>                     
                                                    <td>
                                                        <?php echo date("d-m-Y", strtotime($row->created_at)); ?>
                                                    </td>   
                                                                                              
                                                    <td>                                                      
                                                        <span><a href="edit_user.php?editid=<?php echo htmlentities ($row->id);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="user_create.php?delid=<?php echo ($row->id);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
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