<?php
// Assuming you have the user_id stored in a session variable named 'user_id'
session_start();

// Check if the user_id is set in the session
if(isset($_SESSION['user_id'])) {
    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];
    
    // Construct the response array
    $response = array(
        'status' => true,
        'user_id' => $user_id
    );
} else {
    // User ID not found in session
    $response = array(
        'status' => false,
        'message' => 'User ID not found in session'
    );
}

// Output the response as JSON
echo json_encode($response);
?>
