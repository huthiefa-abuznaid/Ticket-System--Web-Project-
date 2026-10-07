<?php 
session_start();
require_once 'dbconfig.in.php'; 
require_once 'Ticket.php';
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "customer") {
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM tickets WHERE customer_email = :customer_email";
$params = [':customer_email' => $_SESSION['user_email']];
 $description = "";
 $status = "";
 $submitted_date = "";
 $emergency_level = "";
$query ="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $submitted_date = isset($_POST['submitted_date']) ? trim($_POST['submitted_date']) : '';
    $emergency_level = isset($_POST['emergency_level']) ? trim($_POST['emergency_level']) : '';
    if ($description !== '') {
        $sql .= " AND issue_description LIKE :description";
        $params[':description'] = '%' . $description . '%';
    }
    if ($status !== '' && $status !== 'All') {
        $sql .= " AND status = :status";
        $params[':status'] = $status;
    }
    if ($submitted_date !== '') {
        $sql .= " AND date_submitted = :submitted_date";
        $params[':submitted_date'] = $submitted_date;
    }
    if ($emergency_level !== '' && $emergency_level !== 'All') {
        $sql .= " AND urgency_level = :emergency_level";
        $params[':emergency_level'] = $emergency_level;
    }
}
   $hasFilter = $description !== '' || ($status !== '' && $status !== 'All')
    || $submitted_date !== '' || ($emergency_level !== '' && $emergency_level !== 'All');

if (!$hasFilter) {
    $sql .= " AND status = :default_status";
    $params[':default_status'] = 'pending';
}

    $stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!Doctype html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
                <title>Maintenance Request System - customer</title>
</head>
<body>
<header id="main-header">
    <div class="header-brand">
        <img src="Screenshot 2026-08-09 235804.png" class="logo" alt="Ritaj ">
        <h1>Maintenance Request System</h1>
    </div>
    <nav class="main-nav">
        <a href="index.php">Home</a>
        <a href="view.php">View Tickets</a>
        <a href="request.php">Request Maintenance</a>
    </nav>
    <div class="user-info">
        <p class="user-name">Welcome, <?php echo $_SESSION['user_name']; ?></p>
        <p class="user-role role-customer">Customer</p>
    </div>
</header>

<main class="dashboard">
    <section class="card filter-section">
        <form action="customer.php" method="post" class="filter-form">
            <fieldset>
                <legend>Advance Ticket Search</legend>
                <div class="field-group">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description" value="<?php echo $description; ?>">
                </div>
                <div class="field-group">
                    <label for="submitted_date">Submitted Date:</label>
                    <input type="date" name="submitted_date" id="submitted_date" value="<?php echo $submitted_date; ?>">
                </div>
                <div class="field-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="All">All</option>
                        <?php
                        $statuses = ['pending', 'assigned', 'completed'];
                        foreach ($statuses as $s) {
                            $sel = (($_POST['status'] ?? '') == $s) ? 'selected' : '';
                            echo "<option value=\"" .$s . "\" $sel>" . $s . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="field-group">
                    <label for="emergency_level">Emergency Level:</label>
                    <select name="emergency_level" id="emergency_level">
                        <option value="All">Select Emergency Level</option>
                        <?php
                        $levels = ['Low', 'Medium', 'High'];
                        foreach ($levels as $lvl) {
                            $sel = (($_POST['emergency_level'] ?? '') === $lvl) ? 'selected' : '';
                            echo "<option value=\"" . $lvl . "\" $sel>" . $lvl . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="field-group">
                    <input type="submit" value="Search" class="btn btn-primary">
                </div>
            </fieldset>
        </form>
    </section>

    <section class="card ticket-list-section">
        <h1>Tickets List</h1>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Description</th>
                        <th>Submitted Date</th>
                        <th>Customer Name</th>
                        <th>Urgency Level</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($rows as $row) {
                    $ticket = new Ticket(
                        $row['ticket_id'],
                        $row['customer_name'] ?? '',
                        $row['customer_email'] ?? '',
                        $row['customer_location'] ?? '',
                        $row['issue_description'], 
                        $row['date_submitted'], 
                        $row['status'], $row['urgency_level'], 
                        $row['assigned_date'] ?? null,
                        $row['assigned_staff'] ?? null, 
                        $row['ticket_image'] ?? null);
                    echo $ticket->displayTableForCustomer();
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
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
