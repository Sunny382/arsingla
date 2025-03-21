<?php
include('admin/includes/dbconnection.php'); // Include PDO database connection

date_default_timezone_set('Asia/Kolkata'); // Set timezone

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: text/plain");

// List of files to monitor
$files_to_check = ['index.php', 'banner_header.php', 'header.php', 'last_update.php', 'contact.php', 'footer.php', 'counter.php'];
$latest_time = 0;

// Check last modification time for each file
foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $file_mod_time = filemtime($file);
        if ($file_mod_time > $latest_time) {
            $latest_time = $file_mod_time;
        }
    }
}

// Convert latest file modification time to MySQL format
$latest_timestamp = date("Y-m-d H:i:s", $latest_time);

// Fetch stored last update time from database
try {
    $stmt = $dbh->query("SELECT updated_at FROM last_updates WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stored_time = strtotime($row["updated_at"]);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

// If a file has been modified after the last stored time, update the database
if ($latest_time > $stored_time) {
    try {
        $update_stmt = $dbh->prepare("UPDATE last_updates SET updated_at = :updated_at WHERE id = 1");
        $update_stmt->bindParam(':updated_at', $latest_timestamp, PDO::PARAM_STR);
        $update_stmt->execute();
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
        exit();
    }
}

// Fetch latest updated time from database again and display it
try {
    $stmt = $dbh->query("SELECT updated_at FROM last_updates WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo date("d-m-Y H:i:s", strtotime($row["updated_at"]));
} catch (PDOException $e) {
    echo "Error fetching latest update: " . $e->getMessage();
}

?>
