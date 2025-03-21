<?php
include ('header.php');
include('admin/includes/dbconnection.php'); 

//  Fetch all announcements from the database
$query = "SELECT ID, title, message, created_at, expiry_date FROM announcements WHERE expiry_date >= CURDATE() ORDER BY created_at DESC";
$stmt = $dbh->prepare($query);
$stmt->execute();
$announcements = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Announcements</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.php">Home</a></li>                   
                    <li class="current">Announcements</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📢 View All Announcements</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Created Date</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $cnt = 1;
                                if (!empty($announcements)) { 
                                foreach ($announcements as $announcement) { ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlspecialchars($announcement->title); ?></td>
                                        <td><?php echo htmlspecialchars($announcement->message); ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($announcement->created_at)); ?></td>
                                        <td class="text-danger fw-bold"><?php echo date("d-m-Y", strtotime($announcement->expiry_date)); ?></td>                                       
                                    </tr>
                                <?php } 
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Announcements Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include ('footer.php'); ?>
