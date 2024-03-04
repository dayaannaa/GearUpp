<?php
session_start();
if (isset($_SESSION['event_id'])) {
    $eventId = $_SESSION['event_id'];
    echo json_encode(array('event_id' => $eventId));
} else {
    echo json_encode(array('error' => 'event ID not found'));
}
?>