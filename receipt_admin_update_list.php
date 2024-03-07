<?php
inlcude('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Fetch receipt details based on ID and populate form fields for editing
    $id = $_GET["id"];
    $sql = "SELECT * FROM receipt WHERE receipt_id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $receipt_id = $row["receipt_id"];
        $receipt_date = $row["receipt_date"];
        // Populate other form fields here
    } else {
        echo "Receipt not found.";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Handle form submission for updating receipt
    // Fetch and validate form data
    // Update receipt record in the database
    // Redirect to appropriate page after updating
    // Example: header("Location: receipt_list.php");
}
?>
<!-- HTML form for editing receipt details -->