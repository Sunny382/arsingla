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
    $title = $_POST['title'];
    $category = $_POST['category'];
    $journal_name = $_POST['journal_name'];
    $url_link = !empty($_POST['url_link']) ? $_POST['url_link'] : null;
    $publication_date = $_POST['publication_date'];

    // Convert selected values into a comma-separated string
    $indexed = isset($_POST['indexed']) ? implode(',', $_POST['indexed']) : null;
    $eid=$_GET['editid'];

    $sql = "UPDATE publications SET title=:title, category=:category, journal_name=:journal_name, url_link=:url_link, publication_date=:publication_date, indexed=:indexed  WHERE id=:eid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':category', $category, PDO::PARAM_STR);
    $query->bindParam(':journal_name', $journal_name, PDO::PARAM_STR);
    $query->bindParam(':indexed', $indexed, PDO::PARAM_STR);
    $query->bindParam(':url_link', $url_link, PDO::PARAM_STR);
    $query->bindParam(':publication_date', $publication_date, PDO::PARAM_STR);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);

    $query->execute();
        echo '<script>alert("Publications has been updated")</script>';
        echo "<script>window.location.href = 'manage_publications.php'</script>";    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : Publication Update</title>
    <!-- Styles -->
    <link href="../assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/lib/unix.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">
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
                                <h1>Publication</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li class="active">Publication</li>
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
                                    <h4>Update Publication</h4>
                                    <form method="post" name="hjhgh">
                                        <?php
                                            $eid=$_GET['editid'];
                                            $sql="SELECT * from publications where id=$eid";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);

                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $row)
                                            {   
                                                
                                            $selectedIndexes = explode(",", $row->indexed); // Stored values ko array me convert karein
                                                  
                                        ?>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" class="form-control border-none input-flat bg-ash" required="true">
                                                    <option value="International Journal" <?php if ($row->category == "International Journal") echo "selected"; ?>>International Journal</option>
                                                    <option value="National Journal" <?php if ($row->category == "National Journal") echo "selected"; ?>>National Journal</option> 
                                                    <option value="International Conference" <?php if ($row->category == "International Conference") echo "selected"; ?>>International Conference</option>
                                                    <option value="National Conference" <?php if ($row->category == "National Conference") echo "selected"; ?>>National Conference</option>                        
                                                </select>                                                
                                            </div>
                                        </div>                                      

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Title of Paper</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->title);?>" name="title" required="true">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Name of Journal</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->journal_name);?>" name="journal_name" required="true">
                                            </div>
                                        </div>
                                      
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Type of Indexed</label>
                                                <select name="indexed[]" class="form-control border-none input-flat bg-ash selectpicker" multiple data-live-search="true" data-actions-box="true">
                                                    <option value="">Select Indexed</option>                                                     
                                                    <option value="ABDC(A)" <?php if(in_array("ABDC(A)", $selectedIndexes)) echo "selected"; ?>>ABDC(A) Indexed</option>
                                                    <option value="ABDC(B)" <?php if(in_array("ABDC(B)", $selectedIndexes)) echo "selected"; ?>>ABDC(B) Indexed</option>
                                                    <option value="ABDC(C)" <?php if(in_array("ABDC(C)", $selectedIndexes)) echo "selected"; ?>>ABDC(C) Indexed</option>
                                                    <option value="ABDC(D)" <?php if(in_array("ABDC(D)", $selectedIndexes)) echo "selected"; ?>>ABDC(D) Indexed</option>
                                                    <option value="Scopus" <?php if(in_array("Scopus", $selectedIndexes)) echo "selected"; ?>>Scopus Indexed</option>
                                                    <option value="Others" <?php if(in_array("Others", $selectedIndexes)) echo "selected"; ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>URL Link</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->url_link);?>" name="url_link">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Year of Publication</label>
                                                <input type="date" class="form-control border-none input-flat bg-ash" value="<?php  echo htmlentities($row->publication_date);?>" name="publication_date" required="true">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js"></script>
    <!-- Bootstrap Select JS -->
    <script src="../assets/js/scripts.js"></script>
    <!-- scripit init-->
</body>
</html><?php }  ?>