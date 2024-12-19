<?php
$host = 'localhost';
$username = 'server1_gritlife';
$password = 'k+3A[_ed%p2h';
$database = 'server1_gritlife';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstName = $conn->real_escape_string(trim($_POST['first-name']));
    $lastName = $conn->real_escape_string(trim($_POST['last-name']));
    $phone = $conn->real_escape_string(trim($_POST['phoneNumber']));
    $countryCode = $conn->real_escape_string(trim($_POST['countryCode']));

    // Prepare SQL query
    $sql = "INSERT INTO contact_details (first_name, last_name, phone, country_code) VALUES ('$firstName', '$lastName', '$phone', '$countryCode')";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        // Prepare email notification
        $to = "test170924@gmail.com";
        $subject = "New Contact Form Submission";
        $message = "You have received a new contact form submission.\n\nName: $firstName $lastName\nPhone: $phone\nCountry Code: $countryCode";
        $headers = "From: no-reply@example.com";

        // Send email
        if (mail($to, $subject, $message, $headers)) {
            echo "<script>alert('Data saved successfully!'); window.location.href = 'contact.html';</script>";
        } else {
            echo "<script>alert('Data saved but email could not be sent.'); window.location.href = 'contact.html';</script>";
        }
    } else {
        echo "<script>alert('Error saving data: " . $conn->error . "'); window.location.href = 'contact.html';</script>";
    }
}

// Close connection
$conn->close();
?>
