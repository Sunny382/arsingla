<?php
include('includes/dbconnection.php');
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    // Fetch Categories for Assignment page in Select Course Category
    $sql = "SELECT * FROM courses_categories WHERE course_id = :course_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        echo '<option value="">Select Course Category</option>';
        foreach ($results as $row) {
            echo '<option value="' . htmlentities($row->id) . '">' . htmlentities($row->course_category) . '</option>';
        }
    } else {
        echo '<option value="">No Categories Found</option>';
    }
}
?>
