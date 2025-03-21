<?php
include('admin/includes/dbconnection.php'); // Database connection

try {
    $sql = "SELECT title, DATE_FORMAT(created_at, '%d %b %Y') AS formatted_date FROM announcements ORDER BY created_at DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $announcements = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($announcements);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>

