<?php
session_start();
require_once("dbconfig.in.php");

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "customer") {
    header("Location: login.php");
    exit();
}

$ticket_id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($ticket_id === '') {
    $ticket = false;
} else {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_id = :id");
    $stmt->bindValue(':id', $ticket_id);
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!Doctype html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
                <title>Maintenance Request System - conformation</title>
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
            <a href="request.php">Request Maintenance</a>
        </nav>
        <div class="user-info">
            <span class="user-name">Welcome, <?php echo $_SESSION['user_name']; ?></span>
            <span class="user-role role-customer">Customer</span>
        </div>
    </div>
</header>
<main class="page-content">
    <div class="card confirmation-card">
    <h2>Request Submitted Successfully</h2>
    <?php if ($ticket): ?>
    <p>Dear <?php echo $ticket['customer_name']; ?>, thank you for submitting your maintenance request.
       Your ticket has been created in the system with reference number is <span class="ticket-ref"><?php echo sprintf("%03d", $ticket['ticket_id']); ?></span>.</p>
    <ul class="ticket-details">
        <li><strong>Full Name:</strong> <?php echo $ticket['customer_name']; ?></li>
        <li><strong>Email:</strong> <?php echo $ticket['customer_email']; ?></li>
        <li><strong>Location:</strong> <?php echo $ticket['customer_location']; ?></li>
        <li><strong>Issue Description:</strong> <?php echo $ticket['issue_description']; ?></li>
        <li><strong>Urgency Level:</strong> <span class="badge emergency-<?php echo strtolower($ticket['urgency_level']); ?>"><?php echo $ticket['urgency_level']; ?></span></li>
        <li><strong>Submitted Date:</strong> <?php echo $ticket['date_submitted']; ?></li>
        <li><strong>Ticket Status:</strong> <span class="badge status-<?php echo strtolower($ticket['status']); ?>"><?php echo $ticket['status']; ?></span></li>
        <?php if ($ticket['ticket_image']): ?>
        <li><strong>Ticket Image:</strong>
            <div class="ticket-image-wrap">
                <img src="images/<?php echo $ticket['ticket_image']; ?>" alt="Ticket photo">
            </div>
        </li>
        <?php endif; ?>
    </ul>
    <p>Our maintenance team will respond to your request shortly.</p>
    <?php else: ?>
        <p class="error-message">Ticket not found.</p>
    <?php endif; ?>
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