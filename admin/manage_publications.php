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
        $category = $_POST['category'];
        $journal_name = $_POST['journal_name'];
        $url_link = !empty($_POST['url_link']) ? $_POST['url_link'] : null;
        $publication_date = $_POST['publication_date'];

        // Convert selected values into a comma-separated string
        $indexed = isset($_POST['indexed']) ? implode(',', $_POST['indexed']) : null;

        $sql = "INSERT INTO publications (title, category, journal_name, indexed, url_link, publication_date) VALUES (:title, :category, :journal_name, :indexed, :url_link, :publication_date)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':journal_name', $journal_name, PDO::PARAM_STR);
        $query->bindParam(':indexed', $indexed, PDO::PARAM_STR);
        $query->bindParam(':url_link', $url_link, PDO::PARAM_STR);
        $query->bindParam(':publication_date', $publication_date, PDO::PARAM_STR);
        
        $query->execute();
        $LastInsertId=$dbh->lastInsertId();
        if ($LastInsertId>0) {
            echo '<script>alert("Publication has been added.")</script>';
            echo "<script>window.location.href ='manage_publications.php'</script>";
        }
        else
        {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }      
    }

    // Code for deleting book
    if (isset($_GET['delid'])) {

        $rid=intval($_GET['delid']);
        $sql="delete from publications where id=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Publication deleted successfully.');</script>"; 
        echo "<script>window.location.href = 'manage_publications.php'</script>";  
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <title>TSAS : Publication</title>
       <!-- Styles -->
    <link href="../assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/lib/unix.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        .table-responsive {
            overflow-x: auto;
        }
        table.dataTable thead {
            background-color: #007bff;
            color: white;
        }
    </style>
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
                        <div class="col-md-4">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>Create A New Publication</h4>
                                    <form method="post" name="hjhgh">
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" class="form-control border-none input-flat bg-ash" required="true">
                                                    <option value="">Select Category</option>
                                                    <option value="International Journal">International Journal</option>
                                                    <option value="National Journal">National Journal</option> 
                                                    <option value="International Conference">International Conference</option>
                                                    <option value="National Conference">National Conference</option>                        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Title of Paper</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Title of Paper" name="title" required="true">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Name of Journal</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="Name of Journal" name="journal_name" required="true">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Type of Indexed</label>
                                                <select name="indexed[]" class="form-control border-none input-flat bg-ash selectpicker" multiple data-live-search="true" data-actions-box="true">
                                                    <option value="">Select Indexed</option>
                                                    <option value="ABDC(A)">ABDC(A) Indexed</option>
                                                    <option value="ABDC(B)">ABDC(B) Indexed</option>
                                                    <option value="ABDC(C)">ABDC(C) Indexed</option>
                                                    <option value="ABDC(D)">ABDC(D) Indexed</option>
                                                    <option value="Scopus">Scopus Indexed</option> 
                                                    <option value="Others">Others</option>                      
                                                </select>
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>URL Link</label>
                                                <input type="text" class="form-control border-none input-flat bg-ash" placeholder="URL Link" name="url_link">
                                            </div>
                                        </div>

                                        <div class="basic-form m-t-20">
                                            <div class="form-group">
                                                <label>Year of Publication</label>
                                                <input type="date" class="form-control border-none input-flat bg-ash" placeholder="Publication Date" name="publication_date" required="true">
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-default btn-lg m-b-10 bg-warning border-none m-r-5 sbmt-btn" type="submit" name="submit">Add Publication</button>
                                        <button class="btn btn-default btn-lg m-b-10 m-l-5 sbmt-btn" type="reset">Reset</button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>ALL Publication</h4>                                                                  
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="messagesTable" class="table table-bordered table-striped student-data-table m-t-20">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category</th>
                                                    <th>Title of Paper</th>
                                                    <th>Name of Journal</th>
                                                    <th>Type of Indexed</th>
                                                    <th>Publication Year</th>                                                   
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * from publications ORDER BY id DESC";
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
                                                        <?php  echo htmlentities($row->title);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->journal_name);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->indexed);?>
                                                    </td>
                                                    <td>
                                                        <?php  echo htmlentities($row->publication_date);?>
                                                    </td>                                                  
                                                    <td>                                                       
                                                        <span><a href="edit_publication.php?editid=<?php echo htmlentities ($row->id);?>"><i class="ti-pencil-alt color-success"></i></a></span>
                                                        <span><a href="manage_publications.php?delid=<?php echo ($row->id);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="ti-trash color-danger"></i> </a></span>
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
    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js"></script>
    <!-- bootstrap -->
    <script src="../assets/js/scripts.js"></script>
    <!-- scripit init-->

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#messagesTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
</body>
</html><?php }  ?>