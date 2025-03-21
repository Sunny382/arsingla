<?php
include('admin/includes/dbconnection.php'); // Database connection

$category = $_GET['category'] ?? ''; // Get category from URL

try {
    // Prepare and execute query securely using PDO
    $sql = "SELECT * FROM publications WHERE category = :category ORDER BY publication_date DESC LIMIT 4";
    $query = $dbh->prepare($sql);
    $query->bindParam(':category', $category, PDO::PARAM_STR);
    $query->execute();

    // Fetch all results as an associative array
    $publications = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode($publications);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
