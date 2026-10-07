<?php
session_start();
require_once 'dbconfig.in.php';
require_once 'Ticket.php';

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "manager") {
    header("Location: login.php");
    exit();
}

$ticket_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if ($ticket_id !== '' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $checkStmt = $pdo->prepare("SELECT status FROM tickets WHERE ticket_id = :id");
    $checkStmt->bindValue(':id', $ticket_id);
    $checkStmt->execute();
    $currentStatus = $checkStmt->fetchColumn();

    if (in_array($currentStatus, ['assigned', 'completed'])) {
        header("Location: view.php?id=" . $ticket_id);
        exit();
    }

    $staffStmt = $pdo->prepare("SELECT staff_name FROM staff WHERE staff_id = :sid");
    $staffStmt->bindValue(':sid', $_POST['staff_id']);
    $staffStmt->execute();
    $staffRow = $staffStmt->fetch(PDO::FETCH_ASSOC);

    $update = $pdo->prepare("UPDATE tickets SET status = 'assigned', assigned_staff = :staff, assigned_date = :date WHERE ticket_id = :id");
    $update->execute([
        ':staff' => $staffRow['staff_name'] ?? null,
        ':date'  => date('Y-m-d'),
        ':id'    => $ticket_id
    ]);
    header("Location: view.php?id=" . $ticket_id);
    exit();
}
if ($ticket_id === '') {
    $errorMessage = "Invalid ticket ID.";
    $ticket = null;
} else {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_id = :id");
    $stmt->bindValue(':id', $ticket_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $ticket = new Ticket(
            $row['ticket_id'],
             $row['customer_name'], 
             $row['customer_email'], 
             $row['customer_location'],
            $row['issue_description'], 
            $row['date_submitted'], 
            $row['status'], 
            $row['urgency_level'],
            $row['assigned_date'] ?? null, 
            $row['assigned_staff'] ?? null, 
            $row['ticket_image'] ?? null
        );

        if (in_array($ticket->getStatus(), ['assigned', 'completed'])) {
            header("Location: view.php?id=" . $ticket_id);
            exit();
        }
        $errorMessage = '';
    } else {
        $ticket = null;
        $errorMessage = "Ticket not found.";
    }
}

$staffStmt = $pdo->prepare("SELECT staff_id, staff_name FROM staff");
$staffStmt->execute();
$staffList = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!Doctype html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
           <title>Maintenance Request System - Assign Ticket</title>

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
            <a href="<?php echo $_SESSION['user_type'] == 'manager' ? 'manager.php' : 'customer.php'; ?>">View Tickets</a>
        </nav>
        <div class="user-info">
            <p class="user-name">Welcome, <?php echo $_SESSION['user_name']; ?></p>
            <p class="user-role role-manager">Manager</p>
        </div>
    </div>
</header>

<main class="page-content">
    <div class="card form-card">
        <h1>
            Assign Ticket<?php
             if ($ticket) { echo ": #" . sprintf("%03d", $ticket->getTicketId());
             }
              ?>
        </h1>
        <?php if ($ticket) { ?>
        <p>Here is a summary of the information about ticket #<?php echo sprintf("%03d", $ticket->getTicketId()); ?></p>
        <?php echo $ticket->displayTicketsAssigned(); ?>

        <form action="assign.php?id=<?php echo htmlspecialchars($ticket_id); ?>" method="post" class="assign-form">
            <div class="field-group">
                <label for="staff_id">Assign to Staff Member:</label>
                <select name="staff_id" id="staff_id" required>
                    <option value="">-- Select Staff --</option>
                    <?php foreach ($staffList as $staff): ?>
                        <option value="<?php echo $staff['staff_id']; ?>"><?php echo $staff['staff_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" value="Assign Ticket" class="btn btn-primary">
        </form>
        <?php } else { ?>
        <h2>Ticket Not Found</h2>
        <p class="error-message"><?php echo $errorMessage; ?></p>
        <a href="ticketsys.php" class="btn btn-secondary">Back to Dashboard</a>
        <?php } ?>
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