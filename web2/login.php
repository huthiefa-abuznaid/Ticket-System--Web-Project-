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
    <title>Maintenance Request System - Login</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <img src="Screenshot 2026-08-09 235804.png" height="80" alt="Ritaj ">
        <h1>Maintenance Request System</h1>
    </header>
    <hr>

    <main>
        <h2>Login</h2>

        <?php if (!empty($errorMessage)): ?>
            <p style="color: red; font-weight: bold;"><?php echo $errorMessage ?></p>
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
                <input type="submit" value="Login">
            </p>
        </form>
    </main>
    <hr>

   <footer>    
        <p>
            <a href="contact.php">Contact us Page</a> | 
            <a href="tel:+970566770820">+970 566770820 </a>
        </p>
        <p><i>3th Floor Dura city centerBuilding, Omar abn al akahtab  Street, Hebron, Palestine</i></p>
        <p>&copy; 2026 Hutheyfa Ammar - ID 1221065 | <a href="https://www.linkedin.com/in/hutheifa-abuznaid-0116b2422/">Hutheyfa Ammar</a></p>
    </footer>
</body>
</html>