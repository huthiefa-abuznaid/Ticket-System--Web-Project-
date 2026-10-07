# Maintenance Request Ticketing System

A simple web application for managing maintenance requests.
Customers can report a problem, and managers can assign it to a staff member.

Built for the **Web Application and Technologies (COMP 334)** course at Birzeit University.

## Features

- Log in as a **manager** or a **customer**
- Customers can:
  - Send a maintenance request with a photo
  - View and search their own tickets
- Managers can:
  - View and search all tickets
  - Assign a ticket to a staff member
- View the full details of any ticket
- Works on desktop, tablet, and mobile

## Built With

- HTML5
- PHP (PDO)
- MySQL
- CSS3

## Project Parts

| Part | Topic | What it does |
|------|-------|--------------|
| 1 | HTML | Static pages for the website |
| 2 | PHP + MySQL | Login, tickets, search, assign, and upload |
| 3 | CSS | Styling and responsive design |

## How to Run

1. Install a local server such as XAMPP.
2. Copy the project folder into the `htdocs` folder.
3. Create a MySQL database named `ticketSystem`.
4. Import the SQL file into the database.
5. Open `dbconfig.in.php` and enter your database details.
6. Open `http://localhost/your-folder/ticketsys.php` in your browser.

## Main Files

| File | Purpose |
|------|---------|
| `ticketsys.php` | Starting page |
| `login.php` | Checks the user login |
| `request.php` | Sends a new request |
| `confirm.php` | Shows the confirmation |
| `view.php` | Shows ticket details |
| `assign.php` | Assigns a ticket to staff |
| `dbconfig.in.php` | Database connection |
| `style.css` | Design of all pages |



**Hutheyfa**
Computer Science student, Birzeit University
