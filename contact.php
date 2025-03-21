<?php
session_start();
include('admin/includes/dbconnection.php');  // Include PDO connection

// Set response header for JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message_text = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message_text)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    try {
        // Prepare SQL statement
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $dbh->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message_text, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Thank you! Your message has been saved."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save your message. Try again later."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
}
?>
