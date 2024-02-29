<?php
require 'connection.php';

// Retrieve updated event details from the AJAX request
$event_id = $_POST['event_id'];
$event_name = $_POST['event_name'];
$event_color = $_POST['event_color'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date'])); 
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date'])); 

// Prepare the update query using prepared statements to prevent SQL injection
$update_query = "UPDATE calendar_event_master SET 
                 event_name = ?, 
                 event_color = ?, 
                 event_start_date = ?, 
                 event_end_date = ? 
                 WHERE event_id = ?";

$stmt = $conn->prepare($update_query);
$stmt->bind_param("ssssi", $event_name, $event_color, $event_start_date, $event_end_date, $event_id);

if($stmt->execute()) {
    $response = array(
        'status' => true,
        'msg' => 'Event updated successfully!'
    );
} else {
    $response = array(
        'status' => false,
        'msg' => 'Failed to update event: ' . mysqli_error($conn)
    );
}

// Send JSON response back to the frontend
echo json_encode($response);

?>
