<?php
// Include connection.php
require 'connection.php';

// Fetch product data from the products table
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and display product data in the modal table
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Store product data in an array
        $product = array(
            'id' => $row['ProductID'],
            'name' => $row['ProductName'],
            'price' => $row['Price']
        );
        // Add product to products array
        $products[] = $product;
    }
    // Output products array as JSON
    echo json_encode($products);
} else {
    // No products found, display error message
    echo json_encode(array('error' => 'No products found'));
}
?>
