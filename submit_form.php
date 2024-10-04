<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Add your MySQL password here
$dbname = "contact_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successfully!<br>"; // Debug: To check if connected successfully
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Print submitted form data to check values
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Validate inputs
    if (!empty($name) && !empty($phone) && !empty($email)) {
        // Prepare the SQL statement to insert data
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error); // Debug: In case prepare fails
        }

        // Bind parameters
        if (!$stmt->bind_param("sss", $name, $phone, $email)) {
            die("Bind failed: " . $stmt->error); // Debug: In case bind_param fails
        }

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to index.html after successful registration
            header("Location: index.html");
            exit(); // Stop further execution after redirect
        } else {
            echo "Error: " . $stmt->error; // Debug: In case execution fails
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill out all fields.";
    }
}

$conn->close();
?>
