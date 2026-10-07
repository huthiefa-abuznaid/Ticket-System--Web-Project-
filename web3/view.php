<?php
session_start();
require_once 'dbconfig.in.php';
require_once 'Ticket.php';

if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}
$ticket_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if ($ticket_id == '' ) {
    $errorMessage = "Invalid ticket ID.";
    $ticket = null;
} else {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_id = :id");
    $stmt->bindValue(':id', $ticket_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // public function __construct($ticket_id, $customer_name, $customer_email, $customer_location, $issue_description, $date_submitted, $status, $urgency_level, $assigned_date = null, $assigned_staff = null, $ticket_image = null) {
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
        $errorMessage = '';
    } else {
        $ticket = null;
        $errorMessage = "Ticket not found.";
    }
}
?>

    <!Doctype html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
           <title>Maintenance Request System - View Ticket</title>

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
            <p class="user-role role-<?php echo $_SESSION['user_type']; ?>"><?php echo ucfirst($_SESSION['user_type']); ?></p>
        </div>
    </div>
</header>

<main class="page-content">
    <div class="card details-card">
        <h1>
            View Ticket<?php if ($ticket) { echo ": #" . sprintf("%03d", $ticket->getTicketId()); } ?>
        </h1>
        <?php
        if ($ticket) {
            echo $ticket->displayTicketPage();
        } else {
        ?>
            <h2>Ticket Not Found</h2>
            <p class="error-message"><?php echo $errorMessage; ?></p>
            <a href="ticketsys.php" class="btn btn-secondary">Back to Dashboard</a>
        <?php
        }
        ?>
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