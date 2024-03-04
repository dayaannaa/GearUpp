<?php
require 'connection.php'; 

$event_id = $_POST['edit_event_id'];
$event_name = $_POST['edit_event_name'];
$event_start_date = $_POST['edit_event_start_date']; 
$event_end_date = $_POST['edit_event_end_date']; 
$event_start_time = $_POST['edit_event_start_time'];
$event_end_time = $_POST['edit_event_end_time'];
$event_color = $_POST['edit_event_color'];  

// Update the event in the database
$update_query = "UPDATE calendar_event_master SET 
                    event_name = '$event_name', 
                    event_color = '$event_color', 
                    event_start_date = '$event_start_date', 
                    event_end_date = '$event_end_date', 
                    event_start_time = '$event_start_time', 
                    event_end_time = '$event_end_time' 
                    WHERE event_id = $event_id";

if(mysqli_query($conn, $update_query)) {
    $data = array(
        'status' => true,
        'msg' => 'Slot updated successfully!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Sorry, Slot not updated.'				
    );
}
echo json_encode($data);
?>
