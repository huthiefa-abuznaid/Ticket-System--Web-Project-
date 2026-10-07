<?php
session_start();
require_once("dbconfig.in.php");

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "customer") {
    header("Location: login.php");
    exit();
}

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_email = trim($_POST['email'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $urgency = trim($_POST['urgency_level'] ?? 'Low');
    if (empty($_FILES['photo']['name'])) {
    echo "DEBUG error code: " . $_FILES['photo']['error'] . "<br>";
    echo "DEBUG tmp_name: " . $_FILES['photo']['tmp_name'] . "<br>";
    echo "DEBUG ext: " . strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)) . "<br>";
}
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

        if (empty($_FILES['photo']['name'])) {
    echo"Upload error code: " . $_FILES['photo']['error'];
}

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
    <title>Maintenance Request System - request</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="Screenshot 2026-08-09 235804.png" height="80" alt="Ritaj ">
    <h1>Maintenance Request System</h1>
    <a href="index.php">Home</a>
    <br><br>
    <a href="request.php">submit maintenance request</a>
    <br><br>
    <p>welcome <?php echo $_SESSION['user_name']; ?></p>
</header>
<main>
    <h1>submit maintenance request</h1>

    <?php if ($errorMessage): ?>
        <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form action="request.php" method="post" enctype="multipart/form-data">
        <label>name </label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" disabled>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>

        <label for="description">Issue Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="urgency_level">Urgency Level:</label>
        <select id="urgency_level" name="urgency_level">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select><br><br>

        <label for="photo">Upload Photo of the issue(optional) :</label>
        <input type="file" id="photo" name="photo" accept=".jpeg, .jpg"><br><br>

        <input type="submit" value="Submit Request">
    </form>
</main>

<footer>
    <p>
        <a href="contact.php">Contact us Page</a> |
        <a href="tel:+970566770820">+970 566770820 </a>
    </p>
    <p><i>3th Floor Dura city centerBuilding, Omar abn al akahtab Street, Hebron, Palestine</i></p>
    <p>&copy; 2026 Hutheyfa Ammar - ID 1221065 | <a href="https://www.linkedin.com/in/hutheifa-abuznaid-0116b2422/">Hutheyfa Ammar</a></p>
</footer>
</body>
</html>

