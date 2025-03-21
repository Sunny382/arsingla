<?php
include ('header.php');
include('admin/includes/dbconnection.php'); 

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
// Get category from URL
$category = isset($_GET['category']) ? $_GET['category'] : '';
// Get total records count
$total_sql = "SELECT COUNT(*) FROM publications WHERE category = :category";
$total_query = $dbh->prepare($total_sql);
$total_query->bindParam(':category', $category, PDO::PARAM_STR);
$total_query->execute();
$total_records = $total_query->fetchColumn();
$total_pages = ceil($total_records / $limit);

// Fetch data with limit for pagination
$sql = "SELECT * FROM publications WHERE category = :category ORDER BY publication_date DESC LIMIT :start, :limit";
$query = $dbh->prepare($sql);
$query->bindParam(':category', $category, PDO::PARAM_STR);
$query->bindParam(':start', $start, PDO::PARAM_INT);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0"><?php echo htmlspecialchars($category); ?></h1>
            <nav class="breadcrumbs">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current"><?php echo htmlspecialchars($category); ?></li>
            </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->
    <div class="container mt-5">
        <!-- Back Button -->
        <a href="index.php" class="btn btn-secondary mb-3">🔙 Back to Home Page</a>
        <h2 class="mb-4">Publications in All <strong><?php echo htmlspecialchars($category); ?></strong></h2>       
        <!-- Table to Display Publications -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center align-middle">Sr. No.</th>
                        <th class="text-center align-middle">Category</th>
                        <th class="text-center align-middle">Type of Indexed</th>
                        <th class="text-center align-middle">Title of Paper</th>
                        <th class="text-center align-middle">Name of Journal</th>
                        <th class="text-center align-middle">URL Link</th>
                        <th class="text-center align-middle">Publication Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($query->rowCount() > 0) {
                        $sr_no = $start + 1; // Start serial number based on pagination
                        foreach ($results as $row) {
                            echo "<tr>";
                            echo "<td>" . $sr_no++ . "</td>";
                            echo "<td>" . htmlentities($row->category) . "</td>";
                            echo "<td>" . htmlentities($row->indexed) . "</td>";
                            echo "<td>" . htmlentities($row->title) . "</td>";
                            echo "<td>" . htmlentities($row->journal_name) . "</td>";
                            // Make URL clickable only if it exists
                            if (!empty($row->url_link)) {
                                echo "<td><a href='" . htmlentities($row->url_link) . "' target='_blank'>" . htmlentities($row->url_link) . "</a></td>";
                            } else {
                                echo "<td>-</td>";
                            }
                            echo "<td>" . date("d M Y", strtotime($row->publication_date)) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No publications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page - 1; ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page + 1; ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>
<?php
include ('footer.php');
?>