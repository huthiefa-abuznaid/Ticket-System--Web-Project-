<?php
session_start();
require_once("dbconfig.in.php");

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "customer") {
    header("Location: login.php");
    exit();
}

$ticket_id = isset($_GET['id']) ? trim($_GET['id']) : '';
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_id = :id");
$stmt->bindValue(':id', $ticket_id);
$stmt->execute();
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!Doctype html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Maintenance Request System - conformation</title>
               <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <img src="Screenshot 2026-08-09 235804.png" height="80" alt="Ritaj ">
        <h1>Maintenance Request System</h1>
        <a href="index.php" >Home</a>
        
        <br> 
        <a href="request.php" >Request Maintenance</a>
        <p>welcome <?php echo $_SESSION['user_name']; ?> 
    </header>
<main>
    <h2>Request Submitted Successfully</h2>
    <?php if ($ticket): ?>
    <p>Dear <?php echo $ticket['customer_name']; ?>, thank you for submitting your maintenance request.
       Your ticket has been created in the system with reference number is <strong><?php echo sprintf("%03d", $ticket['ticket_id']); ?></strong>.</p>
    <ul>
        <li><strong>Full Name:</strong> <?php echo $ticket['customer_name']; ?></li>
        <li><strong>Email:</strong> <?php echo $ticket['customer_email']; ?></li>
        <li><strong>Location:</strong> <?php echo $ticket['customer_location']; ?></li>
        <li><strong>Issue Description:</strong> <?php echo $ticket['issue_description']; ?></li>
        <li><strong>Urgency Level:</strong> <?php echo $ticket['urgency_level']; ?></li>
        <li><strong>Submitted Date:</strong> <?php echo $ticket['date_submitted']; ?></li>
        <li><strong>Ticket Status:</strong> <?php echo $ticket['status']; ?></li>
        <li><strong>Ticket Image:</strong> </li>
    </ul>
    <?php if ($ticket['ticket_image']): ?>
        <img src="images/<?php echo $ticket['ticket_image']; ?>" width="300">
    <?php endif; ?>
    <p>Our maintenance team will respond to your request shortly.</p>
    <?php else: ?>
        <p style="color: red;">Ticket not found.</p>
    <?php endif; ?>
</main>
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
        