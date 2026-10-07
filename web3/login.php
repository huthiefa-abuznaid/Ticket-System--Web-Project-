<?php
session_start();
require_once 'dbconfig.in.php';
$errorMessage = '';
$user = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_email = :email");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_email'] = $user['user_email'];
                $_SESSION['user_type'] = $user['user_type'];

                header("Location: ticketsys.php");
                exit();
            } else {
                $errorMessage = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Database error: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Please fill in both fields.";
    }
}
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Maintenance Request System - Login</title>
</head>
<body>

    <header id="main-header" class="header-simple">
        <div class="header-brand">
            <img src="Screenshot 2026-08-09 235804.png" class="logo" alt="Ritaj ">
            <h1>Maintenance Request System</h1>
        </div>
    </header>

    <main class="auth-page">
        <div class="card login-card">
            <h2>Login</h2>

            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <p>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </p>
                <p>
                    <input type="submit" value="Login" class="btn btn-primary">
                </p>
            </form>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-contact">
            <address>
                <a href="contact.php">Contact us Page</a> |
                <a href="tel:+970566770820">+970 566770820</a>
                <br>
                3th Floor Dura city center Building, Omar abn al akahtab Street, Hebron, Palestine
            </address>
        </div>
        <div class="footer-copy">
            <p>&copy; 2026 Hutheyfa Ammar - ID 1221065 | <a href="https://www.linkedin.com/in/hutheifa-abuznaid-0116b2422/">Hutheyfa Ammar</a></p>
        </div>
    </footer>
</body>
</html>
