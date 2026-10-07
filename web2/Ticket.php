<?php 
class Ticket {
private $ticket_id;
private $customer_name;
private $customer_email;
private $customer_location;
private $issue_description;
private $date_submitted;
private $status;
private $urgency_level;
private $assigned_date;
private $assigned_staff;
private $ticket_image;

public function __construct($ticket_id, $customer_name, $customer_email, $customer_location, $issue_description, $date_submitted, $status, $urgency_level, $assigned_date = null, $assigned_staff = null, $ticket_image = null) {
    $this->ticket_id = $ticket_id;
    $this->customer_name = $customer_name;
    $this->customer_email = $customer_email;
    $this->customer_location = $customer_location;
    $this->issue_description = $issue_description;
    $this->date_submitted = $date_submitted;
    $this->status = $status;
    $this->urgency_level = $urgency_level;
    $this->assigned_date = $assigned_date;
    $this->assigned_staff = $assigned_staff;
    $this->ticket_image = $ticket_image;
}

public function displayTable() {
    $id = $this->ticket_id;
   

    $action = <<<HTML
    <a href="assign.php?id={$id}" title="Assign Ticket"><img src="Screenshot 2026-08-30 225734.png" alt="Assign" width="20"></a>
    <a href="view.php?id={$id}" title="View Ticket"><img src="Screenshot 2026-08-30 225745.png" alt="View" width="20"></a>
    HTML;

    return "<tr>
        <td>{$this->ticket_id}</td>
        <td>{$this->issue_description}</td>
        <td>{$this->date_submitted}</td>
        <td>{$this->customer_name}</td>
        <td>{$this->urgency_level}</td>
        <td>{$this->status}</td>
        <td>{$action}</td>
    </tr>";
}
public function displayTableForCustomer() {
    $id = $this->ticket_id;
   

    $action = <<<HTML
    <a href="view.php?id={$id}" title="View Ticket"><img src="Screenshot 2026-08-30 225745.png" alt="View" width="20"></a>
    HTML;

    return "<tr>
        <td>{$this->ticket_id}</td>
        <td>{$this->issue_description}</td>
        <td>{$this->date_submitted}</td>
        <td>{$this->customer_name}</td>
        <td>{$this->urgency_level}</td>
        <td>{$this->status}</td>
        <td>{$action}</td>
    </tr>";
}

public function displayTicketPage() {
    $p = "<main><ul>";
    $p .= "<li><strong>Customer Name:</strong> {$this->customer_name}</li>";
    $p .= "<li><strong>Email:</strong> {$this->customer_email}</li>";
    $p .= "<li><strong>Location:</strong> {$this->customer_location}</li>";
    $p .= "<li><strong>Issue Description:</strong> {$this->issue_description}</li>";
    $p .= "<li><strong>Urgency Level:</strong> {$this->urgency_level}</li>";
    $p .= "<li><strong>Date Submitted:</strong> {$this->date_submitted}</li>";
    $p .= "<li><strong>Ticket Status:</strong> {$this->status}</li>";
    $p .= "<li><strong>Assigned to:</strong> " . ($this->assigned_staff ?? 'N/A');
    $p .= ($this->assigned_staff && $this->assigned_date) ? " on " . $this->assigned_date : "";
    $p .= "</li>";
    if ($this->ticket_image) {
        $p .= "<li><strong>Photo Uploaded:</strong><br><img src='images/{$this->ticket_image}' width='300'></li>";
    } else {
        $p .= "<li><strong>Photo Uploaded:</strong> No image uploaded</li>";
    }
    $p .= "</ul></main>";
    return $p;
}   
public function displayTicketsAssigned() {
    $p = "<main><ul>";
    $p .= "<li><strong>Issue Description:</strong> {$this->issue_description}</li>";
    $p .= "<li><strong>Urgency Level:</strong> {$this->urgency_level}</li>";
    $p .= "<li><strong>Date Submitted:</strong> {$this->date_submitted}</li>";
    $p .= "<li>Assign to Staff Member: {$this->assigned_staff}</li>";
    $p .= "</ul></main>";
    return $p;
}

public function getTicketId() { return $this->ticket_id; }
    public function getCustomerName() { return $this->customer_name; }
    public function getIssueDescription() { return $this->issue_description; }
    public function getDateSubmitted() { return $this->date_submitted; }
    public function getStatus() { return $this->status; }
    public function getUrgencyLevel() { return $this->urgency_level; }
    public function getAssignedDate() { return $this->assigned_date; }
    public function getAssignedStaff() { return $this->assigned_staff; }
   
 public function getTicketImage() { return $this->ticket_image; }
    
    public function setStatus($status) { $this->status = $status; }
    public function setAssignedStaff($staff) { $this->assigned_staff = $staff; }
    public function setAssignedDate($date) { $this->assigned_date = $date; 
    }
}
