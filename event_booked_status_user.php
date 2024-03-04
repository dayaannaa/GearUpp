<?php
require 'connection.php';

if(isset($_POST['eventId']) && !empty($_POST['eventId']) && isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['balance']) && !empty($_POST['balance'])) {
    $eventId = $_POST['eventId'];
    $userId = $_POST['userId'];
    $balance = $_POST['balance'];
    $amount = $balance - 200;
    $paymentDate = date('Y-m-d H:i:s');
    
    $updateQuery = "UPDATE calendar_event_master 
                    SET event_name = 'Booked', 
                        event_color = '#ff6767' 
                    WHERE event_id = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("i", $eventId);

    if ($stmtUpdate->execute()) {
        $insertAppointmentQuery = "INSERT INTO appointment (user_id, event_id) VALUES (?, ?)";
        $stmtAppointment = $conn->prepare($insertAppointmentQuery);
        $stmtAppointment->bind_param("ii", $userId, $eventId);

        if ($stmtAppointment->execute()) {
            $appointmentId = $stmtAppointment->insert_id;

            $insertPaymentQuery = "INSERT INTO payment (appointment_id, amount, payment_date) VALUES (?, ?, ?)";
            $stmtPayment = $conn->prepare($insertPaymentQuery);
            $stmtPayment->bind_param("ids", $appointmentId, $amount, $paymentDate);

            if ($stmtPayment->execute()) {
                $response = array(
                    'status' => true,
                    'msg' => 'Appointment Slot Successfully Booked! Payment made.'
                );
            } else {
                $response = array(
                    'status' => false,
                    'msg' => 'Failed to insert into payment table: ' . $conn->error
                );
            }
        } else {
            $response = array(
                'status' => false,
                'msg' => 'Failed to insert into appointment table: ' . $conn->error
            );
        }
    } else {
        $response = array(
            'status' => false,
            'msg' => 'Failed to update event status: ' . $conn->error
        );
    }
} else {
    $response = array(
        'status' => false,
        'msg' => 'Event ID, User ID, or Balance is missing'
    );
}

echo json_encode($response);
?>
