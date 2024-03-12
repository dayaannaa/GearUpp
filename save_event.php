<?php                
require 'connection.php'; 

$event_name = $_POST['event_name'];
$event_start_date = $_POST['event_start_date']; 
$event_end_date = $_POST['event_end_date']; 
$event_start_time = $_POST['event_start_time'];
$event_end_time = $_POST['event_end_time'];
$event_color = $_POST['event_color'];  
$duration = $_POST['duration'];
$num_time_slots = $_POST['num_time_slots'];

$insert_query = "INSERT INTO `calendar_event_master` (`event_name`, `event_start_date`, `event_end_date`, `event_start_time`, `event_end_time`, `event_color`, `duration`, `num_time_slots`) 
                 VALUES ('$event_name', '$event_start_date', '$event_end_date', '$event_start_time', '$event_end_time', '$event_color', '$duration', '$num_time_slots')";  

if(mysqli_query($conn, $insert_query)) {
    $data = array(
        'status' => true,
        'msg' => 'Slot added successfully!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Sorry, Slot not added.'				
    );
}
echo json_encode($data);	
?>

