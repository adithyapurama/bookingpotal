<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = 'jashu';
$database = 'event_booking';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database,"3307");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize form data
function sanitizeData($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form data
    $eventName = sanitizeData($_POST['eventName']);
    $facultyName = sanitizeData($_POST['facultyName']);
    $eventTimings = sanitizeData($_POST['eventTimings']);
    $organizers = sanitizeData($_POST['organizers']);
    $facultyContact = sanitizeData($_POST['facultyContact']);
    $selectedDate = sanitizeData($_POST['selectedDate']);

    // Use prepared statements to insert data into the database
    $sql = "INSERT INTO event_bookings (event_name, faculty_name, event_timings, organizers, faculty_contact, selected_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $eventName, $facultyName, $eventTimings, $organizers, $facultyContact, $selectedDate);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
