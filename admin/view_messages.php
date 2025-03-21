<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <title>TSAS : View Messages</title>   
    <!-- Styles -->
    <link href="../assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="../assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/lib/unix.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">

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
                            <h1>View Messages</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li class="active">View Messages</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="main-content">
                <div class="row">                       
                    <div class="col-md-12">
                        <div class="card alert">
                            <div class="card-header pr">
                                <h2 class="text-center text-primary">📩 Contact Messages</h2>                                                                 
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="messagesTable" class="table table-bordered table-striped">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>S.No</th>                                                  
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Received At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            try {
                                                $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->execute();
                                                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                $sno = 1;

                                                if (count($messages) > 0) {
                                                    foreach ($messages as $row) {
                                                        echo "<tr>
                                                            <td class='text-center'>{$sno}</td>
                                                            <td>{$row['name']}</td>
                                                            <td>{$row['email']}</td>
                                                            <td>{$row['subject']}</td>
                                                            <td>{$row['message']}</td>
                                                            <td class='text-center'>{$row['created_at']}</td>
                                                        </tr>";
                                                        $sno++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center text-danger'>No messages found.</td></tr>";
                                                }
                                            } catch (PDOException $e) {
                                                echo "<tr><td colspan='6' class='text-center text-danger'>Error fetching messages: " . $e->getMessage() . "</td></tr>";
                                            }
                                            ?>                                            
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

<!-- jQuery & DataTables Scripts -->
<script src="../assets/js/lib/jquery.min.js"></script>
<script src="../assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="../assets/js/lib/menubar/sidebar.js"></script>
<script src="../assets/js/lib/preloader/pace.min.js"></script>
<script src="../assets/js/lib/bootstrap.min.js"></script>
<script src="../assets/js/scripts.js"></script>

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
</html>
