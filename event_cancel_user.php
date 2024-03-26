<?php
include "dbconn.php";

if(isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    
    $fetch_event_sql = "SELECT event_id FROM appointment WHERE appointment_id = ?";
    $fetch_event_stmt = $conn->prepare($fetch_event_sql);
    $fetch_event_stmt->bind_param("i", $appointment_id);
    $fetch_event_stmt->execute();
    $fetch_event_result = $fetch_event_stmt->get_result();
    
    if ($fetch_event_result->num_rows > 0) {
        $row = $fetch_event_result->fetch_assoc();
        $event_id = $row['event_id'];
        
        $update_appointment_sql = "UPDATE appointment SET status = 'Failed' WHERE appointment_id = ?";
        $update_appointment_stmt = $conn->prepare($update_appointment_sql);
        $update_appointment_stmt->bind_param("i", $appointment_id);
        $update_appointment_stmt->execute();
        
        if ($update_appointment_stmt->affected_rows > 0) {
            $update_slots_sql = "UPDATE calendar_event_master SET num_time_slots = num_time_slots + 1 WHERE event_id = ?";
            $update_slots_stmt = $conn->prepare($update_slots_sql);
            $update_slots_stmt->bind_param("i", $event_id);
            $update_slots_stmt->execute();
            
            $update_event_status_sql = "UPDATE calendar_event_master SET event_name = IF(num_time_slots = 0, 'Fully Booked', 'Available'), event_color = IF(num_time_slots = 0, '#ff0000', '#52f222') WHERE event_id = ?";
            $update_event_status_stmt = $conn->prepare($update_event_status_sql);
            $update_event_status_stmt->bind_param("i", $event_id);
            $update_event_status_stmt->execute();
            
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
        } else {
            echo "Failed to update appointment status.";
        }
    } else {
        echo "Event ID not found for the appointment.";
    }
    
    $fetch_event_stmt->close();
    $update_appointment_stmt->close();
    $update_slots_stmt->close();
    $update_event_status_stmt->close();
    $conn->close();
} else {
    echo "Appointment ID not provided.";
}
?>
