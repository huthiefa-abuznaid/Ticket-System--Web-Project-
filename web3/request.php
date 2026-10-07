<?php
session_start();
require_once("dbconfig.in.php");

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "customer") {
    header("Location: login.php");
    exit();
}

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $customer_email = $_SESSION['user_email'];
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $urgency = trim($_POST['urgency_level'] ?? 'Low');
    if ($customer_email === '' || $location === '' || $description === '') {
        $errorMessage = "Please fill in all required fields.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tickets (customer_name, customer_email, customer_location, issue_description, urgency_level, status, date_submitted) VALUES (:name, :email, :location, :description, :urgency, 'pending', NOW())");
        $stmt->execute([
            ':name'        => $_SESSION['user_name'],
            ':email'       => $customer_email,
            ':location'    => $location,
            ':description' => $description,
            ':urgency'     => $urgency
        ]);
        $ticket_id = $pdo->lastInsertId();

if (!empty($_FILES['photo']['name']) ) {
    $tmpName = $_FILES['photo']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, ['jpg', 'jpeg'])) {
        $fileName = $_FILES['photo']['name'];
        $destination = 'images/' . $fileName;

        if (!is_dir('images')) {
            mkdir('images', 0755, true);
        }

        if (!move_uploaded_file($tmpName, $destination)) {
            error_log("move_uploaded_file failed: $tmpName -> $destination");
        } else {
            $updateImg = $pdo->prepare("UPDATE tickets SET ticket_image = :img WHERE ticket_id = :id");
            $updateImg->execute([':img' => $fileName, ':id' => $ticket_id]);
        }
    }
}

        header("Location: confirm.php?id=" . $ticket_id);
        exit();
    }
}
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Maintenance Request System - request</title>
</head>
<body>
<header id="main-header">
    <div class="header-logo">
        <img src="Screenshot 2026-08-09 235804.png" class="logo" alt="Ritaj ">
    </div>
    <h1 class="header-title">Maintenance Request System</h1>
    <div class="header-actions">
        <nav class="main-nav">
            <a href="ticketsys.php">Home</a>
            <a href="request.php">Submit Maintenance Request</a>
        </nav>
        <div class="user-info">
            <p class="user-name">Welcome, <?php echo $_SESSION['user_name']; ?></p>
            <p class="user-role role-customer">Customer</p>
        </div>
    </div>
</header>
<main class="page-content">
    <div class="card form-card">
        <h1>Submit Maintenance Request</h1>

        <?php if ($errorMessage): ?>
            <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>

        <form action="request.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" disabled>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </p>
            <p>
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </p>
            <p>
                <label for="description">Issue Description:</label>
                <textarea id="description" name="description" required></textarea>
            </p>
            <p>
                <label for="urgency_level">Urgency Level:</label>
                <select id="urgency_level" name="urgency_level">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </p>
            <p>
                <label for="photo">Upload Photo of the issue (optional):</label>
                <input type="file" id="photo" name="photo" accept=".jpeg, .jpg">
            </p>
            <p>
                <input type="submit" value="Submit Request" class="btn btn-primary">
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