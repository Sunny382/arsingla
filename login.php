<?php
session_start();
include('admin/includes/dbconnection.php'); 

if (isset($_GET['course_id']) && isset($_GET['category_id'])) {
    $_SESSION['course_id'] = $_GET['course_id'];
    $_SESSION['category_id'] = $_GET['category_id'];
}

// Initialize error variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE email = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "❌ User not found!"; 
    } else {
        if ($password === $user['password']) { 
            $_SESSION['user_id'] = $user['id'];

            if (isset($_SESSION['course_id']) && isset($_SESSION['category_id'])) {
                $redirect_url = "downloads.php?course_id=" . urlencode($_SESSION['course_id']) . "&category_id=" . urlencode($_SESSION['category_id']);
                header("Location: $redirect_url");
                exit();
            } else {
                header("Location: downloads.php");
                exit();
            }
        } else {
            $error = "❌ Invalid password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Dr. Ashim Raj Singla</title>
    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/drsingla1.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            margin-top: 100px;
        }
        .login-card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background: white;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <h2 class="text-center mb-4">Login</h2>

                    <!-- Error Message Display -->
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <!-- Login Form -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>               
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (for responsive & animations) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


