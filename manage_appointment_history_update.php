<?php
require 'connection.php';

// Check if appointment_id and status are provided
if(isset($_POST['appointmentId'], $_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];

    // Update appointment status
    $updateQuery = "UPDATE appointment SET status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $appointmentId);

    if ($stmt->execute()) {
        // Success response
        $response = array(
            'status' => true,
            'msg' => 'Appointment status updated successfully'
        );
    } else {
        // Error response
        $response = array(
            'status' => false,
            'msg' => 'Failed to update appointment status: ' . $conn->error
        );
    }
} else {
    // Invalid request parameters
    $response = array(
        'status' => false,
        'msg' => 'Missing required parameters'
    );
}

// Output JSON response
echo json_encode($response);

?>
