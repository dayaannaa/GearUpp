<?php
require 'connection.php';

if(isset($_POST['eventId'], $_POST['userId'], $_POST['balance'], $_POST['startTime'], $_POST['endTime'], $_POST['serviceId'])) {
    $eventId = $_POST['eventId'];
    $serviceId = $_POST['serviceId'];
    $userId = $_POST['userId'];
    $balance = $_POST['balance'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $amount = $balance - 200;

    $status = "Pending";

    $insertQuery = "INSERT INTO appointment (event_id, user_id, start_time, end_time, ServiceID, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iissis", $eventId, $userId, $startTime, $endTime, $serviceId, $status);

    if ($stmt->execute()) {

        $query = "SELECT num_time_slots FROM calendar_event_master WHERE event_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $numTimeSlots = $row['num_time_slots'];

        $numTimeSlots--;

        $updateSlotsQuery = "UPDATE calendar_event_master SET num_time_slots = ? WHERE event_id = ?";
        $stmt = $conn->prepare($updateSlotsQuery);
        $stmt->bind_param("ii", $numTimeSlots, $eventId);
        $stmt->execute();

        if ($numTimeSlots == 0) {
            $updateEventQuery = "UPDATE calendar_event_master SET event_name = 'Fully Booked', event_color = '#ff6767' WHERE event_id = ?";
            $stmt = $conn->prepare($updateEventQuery);
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
        }
    
        $response = array(
            'status' => true,
            'msg' => 'Appointment created successfully'
        );
    } else {
        $response = array(
            'status' => false,
            'msg' => 'Failed to create appointment: ' . $conn->error
        );
    }
} else {
    $response = array(
        'status' => false,
        'msg' => 'Missing required parameters'
    );
}
echo json_encode($response);
?>
