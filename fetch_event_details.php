<?php
require 'connection.php';

if(isset($_POST['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);

    $query = "SELECT * FROM calendar_event_master WHERE event_id = '$event_id'";

    $result = mysqli_query($conn, $query);

    if($result) {
        $event_details = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        echo json_encode(array(
            'status' => true,
            'event_details' => $event_details
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'msg' => 'Failed to fetch event details from the database.'
        ));
    }
} else {
    echo json_encode(array(
        'status' => false,
        'msg' => 'Event ID is required.'
    ));
}
?>
