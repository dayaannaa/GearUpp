<?php
require 'connection.php'; 

// Check if user_id is set and not empty
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    // Get user ID from the POST data
    $user_id = $_POST['user_id'];
    
    // Prepare and execute the query using a prepared statement
    $display_query = "SELECT * FROM user_info WHERE user_id = ?";
    $stmt = $conn->prepare($display_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch user information as an associative array
        $data_arr = $result->fetch_assoc();
        $data = array(
            'status' => true,
            'msg' => 'Successfully!',
            'data' => $data_arr
        );
    } else {
        // No user found with the provided ID
        $data = array(
            'status' => false,
            'msg' => 'User not found'
        );
    }
} else {
    // User ID is missing from the POST data
    $data = array(
        'status' => false,
        'msg' => 'User ID is missing'
    );
}

// Output JSON response
echo json_encode($data);
?>
