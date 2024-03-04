<?php
require 'connection.php';

if(isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $delete_query = "DELETE FROM calendar_event_master WHERE event_id = $event_id";

    if(mysqli_query($conn, $delete_query)) {
        $response = array(
            'status' => true,
            'msg' => 'Event deleted successfully!'
        );
    } else {
        $response = array(
            'status' => false,
            'msg' => 'Failed to delete event.'
        );
    }
} else {
    $response = array(
        'status' => false,
        'msg' => 'Event ID is missing.'
    );
}

echo json_encode($response);
?>
