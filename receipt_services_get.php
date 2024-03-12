<?php
// Include connection.php
require 'connection.php';

// Fetch service data from the services table
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and display service data in the modal table
    $services = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Store service data in an array
        $service = array(
            'id' => $row['ServiceID'],
            'name' => $row['ServiceName'],
            'cost' => $row['Price']
        );
        // Add service to services array
        $services[] = $service;
    }
    // Output services array as JSON
    echo json_encode($services);
} else {
    // No services found, display error message
    echo json_encode(array('error' => 'No services found'));
}
?>
