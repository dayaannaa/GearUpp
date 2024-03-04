<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    echo json_encode(array('user_id' => $userId));
} else {
    echo json_encode(array('error' => 'User ID not found'));
}
?>
