<?php
// Include your database connection file
require 'connection.php';

// Check if event ID is provided via POST request
if(isset($_POST['event_id'])) {
    // Sanitize the input to prevent SQL injection
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);

    // Query to fetch event details from the database
    $query = "SELECT * FROM calendar_event_master WHERE event_id = '$event_id'";

    $result = mysqli_query($conn, $query);

    if($result) {
        // Fetch event details
        $event_details = mysqli_fetch_assoc($result);

        // Close the database connection
        mysqli_close($conn);

        // Send JSON response with event details
        echo json_encode(array(
            'status' => true,
            'event_details' => $event_details
        ));
    } else {
        // If query execution fails
        echo json_encode(array(
            'status' => false,
            'msg' => 'Failed to fetch event details from the database.'
        ));
    }
} else {
    // If event ID is not provided in the request
    echo json_encode(array(
        'status' => false,
        'msg' => 'Event ID is required.'
    ));
}
?>
