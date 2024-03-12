<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Fetch receipt details based on ID
    $id = $_GET["id"];
    $sql = "SELECT * FROM receipt WHERE receipt_id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Store fetched data into variables for displaying in form
        $receipt_id = $row["receipt_id"];
        $receipt_date = $row["receipt_date"];
        // Populate other form fields here
    } else {
        echo "Receipt not found.";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Handle form submission for updating receipt
    // Fetch and validate form data
    // Update receipt record in the database
    $receipt_id = $_POST["receipt_id"];
    $receipt_date = $_POST["receipt_date"];
    // Retrieve other form fields here

 // Fetch product information based on receipt ID
$product_query = "SELECT rp.id, rp.quantity, p.ProductName, rp.cost
FROM receipt_products rp
INNER JOIN products p ON rp.ProductID = p.ProductID
WHERE rp.receipt_id = ?";
$product_statement = $conn->prepare($product_query);
$product_statement->bind_param("i", $receipt_id); // Use "i" for integer type
$product_statement->execute();
$product_result = $product_statement->get_result();

// Fetch service information based on receipt ID
$service_query = "SELECT rs.id, s.ServiceName, rs.cost
FROM receipt_services rs
INNER JOIN services s ON rs.ServiceID = s.ServiceID
WHERE rs.receipt_id = ?";
$service_statement = $conn->prepare($service_query);
$service_statement->bind_param("i", $receipt_id); // Use "i" for integer type
$service_statement->execute();
$service_result = $service_statement->get_result();

    // Handle errors
    if (!$product_result || !$service_result) {
        echo "Error executing query: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>



<?php 
    $query = "SELECT * FROM receipt_products";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            $receiptProductId = $row['id'];
        } else {
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
?>

<?php 
    $query = "SELECT * FROM receipt_services";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            $receiptServiceId = $row['id'];
        } else {
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
?>

<?php
$product_query_total = "SELECT SUM(cost) AS total_product_cost FROM receipt_products WHERE receipt_id = $receipt_id";
$product_result_total = mysqli_query($conn, $product_query_total);
$product_row_total = mysqli_fetch_assoc($product_result_total);
$total_product_cost = $product_row_total['total_product_cost'];

$service_query_total = "SELECT SUM(cost) AS total_service_cost FROM receipt_services WHERE receipt_id = $receipt_id";
$service_result_total = mysqli_query($conn, $service_query_total);
$service_row_total = mysqli_fetch_assoc($service_result_total);
$total_service_cost = $service_row_total['total_service_cost'];

$subtotal = $total_product_cost + $total_service_cost;
$taxrate = 12;
$tax = $taxrate * $subtotal / 100;
$grandtotal = $subtotal + $tax;
?>

<?php
require 'connection.php';

$query = "SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.address, u.city
          FROM receipt r
          INNER JOIN user_info u ON r.user_id = u.user_id
          WHERE r.receipt_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $receipt_id); // Use "i" for integer type
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Retrieve user information
    $user_id = $row["user_id"];
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
    $city = $row["city"];
} else {
    echo "User information not found.";
}
$stmt->close();
?>

<?php
$receiptDate = "";
$sql = "SELECT receipt_date FROM receipt WHERE receipt_id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_receipt_id);
$stmt->execute();
$stmt->bind_result($receiptDate);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https:fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https:cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
<!-- JS for jQuery -->
<script src="https:cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calender -->
<script src="https:cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https:cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
<link rel="stylesheet" href="https:maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https:cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
<script src="https:cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script src="https:maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<style>
    #userModalContent{
        width: fit-content;
    }

    body {
        overflow-x: auto;
    }

    header {
        height: 80px;
        margin-left: 40px;
        z-index: 1;
    }

    .create-receipt {
    background-color: #f2f2f2;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width: 300px;
    margin-top: 10px;
    margin-left: 120px;
}

.create-receipt h2 {
    color: #333;
    margin-bottom: 20px;
}

.create-receipt label {
    font-weight: bold;
    margin-bottom: 5px;
}

.create-receipt input[type="text"],
.create-receipt input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.create-receipt input[type="text"]:focus,
.create-receipt input[type="date"]:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

#customer_information {
    background-color: #f2f2f2;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* margin-bottom: 20px; */
    /* margin-left: 110px; */
    width: 75.5%;
    /* margin-top: 10px; */
    transform: translate(440px, -280px);
}

.classProducts {
    background-color: #f2f2f2;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* margin-bottom: 20px; */
    /* margin-left: 110px; */
    width: 92.7%;
    /* margin-top: 10px; */
    transform: translate(120px, -280px);
}

#customer_information h3 {
    color: #333;
    margin-bottom: 20px;
}

#customer_information label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

#customer_information input[type="text"],
#customer_information input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

#customer_information input[type="text"]:focus,
#customer_information input[type="email"]:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

#verifyButton {
    padding: 10px 20px;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.totalCompute{
    position:fixed:
}
</style>
<body>
    <?php
    include "sidebar.html";
    ?>
    <!-- <header id="header" class="fixed-top header-inner-pages bg-black">
    </header> -->
<section class="breadcrumbs">
<div class="container">

    <div class="d-flex justify-content-between align-items-center">
        <h2>Create New <span class="invoice_type">Receipt</span> </h2>
		<!-- <hr> -->

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
        <ol>
        <li><a href="admin_dash.php">Home</a></li>
        <li>Receipt</li>
        </ol>
    </div>
</div>

</section>
<div class="create-receipt">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Receipt ID -->
        <label for="receipt_id">Receipt ID:</label>
        <input type="text" id="receipt_id" name="receipt_id" value="<?php echo $receipt_id; ?>" readonly>

        <!-- Receipt Date -->
        <label for="receipt_date">Receipt Date:</label>
        <input type="date" id="receipt_date" name="receipt_date" value="<?php echo $receiptDate; ?>"required><br><br>
</div>

        <!-- Customer Information -->
        <div id="customer_information">
        <h3>Customer Information<!-- Button to trigger modal -->
    </h3>
    <div class="input-group">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required value="<?php echo $first_name; ?>">
    </div>
    <div class="input-group">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required value="<?php echo $last_name; ?>">
    </div>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope"></i>Email:</span>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
    </div>
    <div class="input-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
    </div>
    <div class="input-group">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $city; ?>">
    </div>
    <button type="button" class="btn btn-secondary" id="verifyButton"><i class="fa fa-lock verify" aria-hidden="true"></i></button>
</div>


    </form>

      <!-- Modal -->
      <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="userModalContent">
                <div class="modal-header">
                    <p id="select-existing-user" style="cursor: pointer;">Select Existing User</p>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        require 'connection.php';
                        $query = "SELECT * FROM user_info WHERE receipt_id=";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td><button class='btn btn-primary select-user' data-firstname='" . $row['first_name'] . "' data-user_id='" . $row['user_id'] . "' data-lastname='" . $row['last_name'] . "' data-email='" . $row['email'] . "' data-phone='" . $row['phone'] . "' data-address='" . $row['address'] . "' data-city='" . $row['city'] . "'>Select</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><br>
    
<div class="classProducts">
    <!-- Products Section -->
    <h4>Products:</h4>
<div class="col-md-3">
    <div class="form-group">
        <label for="form_id" class="control-label">Name:</label>
        <select id="form_id" class="custom-select custom-select-sm select2">
            <option selected disabled>Loading Products...</option>
        </select>
    </div>
		<div class="form-group">
			<label for="qty" class="control-label">Quantity:</label>
			<input type="number" min='1' id="qty"  value="1" class="form-control text-right">
		</div>
		<div class="form-group">
			<label for="qty" class="control-label">Price:</label>
			<input type="text" id="price" placeholder="₱"class="form-control text-right" readonly>
		</div>
    <button type="button" id="add_product_row" class="btn btn-primary">+</button> 
</div>

    <div id="products_section">
    <table id="products_table" class="table">
    <thead>
        <tr>
            <th>Quantity</th>
            <th width="500">Products</th>
            <th>Cost</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($product_row = mysqli_fetch_assoc($product_result)) {
 print_r($product_row);
        echo "<tr>";
        echo "<td>" . $product_row['quantity'] . "</td>";
        echo "<td>" . $product_row['ProductName'] . "</td>";
        echo "<td>" . $product_row['cost'] . "</td>";
        echo "<td><button type='button' class='btn btn-warning delete-product' data-receipt-product-id='{$product_row['id']}'>x</button></td>";
        echo "</tr>";
    }
    ?>
</tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="right"><strong>Total:</strong></td>
            <td><span id="products_total_amount">0</span></td>
        </tr>
    </tfoot>
</table>
    </div>
    <div>
    <h4>Services:</h4>
    <div class="col-md-3">
        <div class="form-group">
            <label for="service_id" class="control-label">Service Name:</label>
            <select id="service_id" class="custom-select custom-select-sm select2">
                <option selected disabled>Loading Services...</option>
                <!-- Options for services will be populated dynamically -->
            </select>
        </div>
        <div class="form-group">
            <label for="service_cost" class="control-label">Cost:</label>
            <input type="text" id="service_cost" class="form-control text-right">
        </div>
        <button type="button" id="add_service_row" class="btn btn-primary">+</button>
    </div>
    <div id="services_section">
    <table id="services_table" class="table">
    <thead>
        <tr>
            <th width="500">Services</th>
            <th>Cost</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($service_row = mysqli_fetch_assoc($service_result)) {
         print_r($service_row);
        echo "<tr>";
        echo "<td>" . $service_row['ServiceName'] . "</td>";
        echo "<td>" . $service_row['cost'] . "</td>";
        echo "<td><button type='button' class='btn btn-warning delete-service' data-receipt-service-id='{$service_row['id']}'>x</button></td>";
        echo "</tr>";
    }
    ?>
</tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="right"><strong>Total:</strong></td>
            <td><span id="services_total_amount">0</span></td>
        </tr>
    </tfoot>
</table>
<div align="right" class="totalCompute">
    <strong>Subtotal:</strong>
    <span>₱<?php echo number_format($subtotal, 2); ?></span><br>
    <strong>Tax Rate:</strong>
    <span><?php echo number_format($taxrate); ?>&percnt;</span><br>
    <strong>Tax:</strong>
    <span>₱<?php echo number_format($tax, 2); ?></span><br>
    <strong>Grand Total:</strong>
    <span id="grand_total">₱<?php echo number_format($grandtotal, 2); ?></span><br>
    
    <!-- Back button -->
    <button type="button" id="backToReceiptLists" class="btn btn-secondary">Back (to Receipt Lists)</button>

    <!-- Submit button -->
    <button type="button" id="submitReceipt" class="btn btn-primary">Submit (Receipt)</button>
</div>

    </div>
    <div>
</div>

    <!-- JavaScript to fetch and populate user data in the modal -->
<script>

$(document).ready(function() {
    $('#verifyButton').click(function() {
         Retrieve values from input fields
        var receiptDate = $('#receipt_date').val();
        var userId = $('#user_id').val();
        var receiptId = $('#receipt_id').val();
        
         Prepare data to send to server
        var data = {
            receiptDate: receiptDate,
            userId: userId,
            receiptId: receiptId
        };
        
         Send AJAX request to insert data into receipt table
        $.ajax({
            url: 'receipt_admin_lock_user.php',
            method: 'POST',
            data: data,
            success: function(response) {
                 Handle success
                console.log('Receipt inserted successfully:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                 Handle error
                console.error('Error inserting receipt:', error);
                alert("Please fill in all fields.")
            }
        });
    });
});

        $(document).on("click", ".select-user", function() {
         Get the user data from the button's data attributes
        var user_id = $(this).data('user_id');
        var firstName = $(this).data('firstname');
        var lastName = $(this).data('lastname');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var address = $(this).data('address');
        var city = $(this).data('city');        
        
         Set the selected user data in the form fields or perform any other action
        $('#first_name').val(firstName);
        $('#last_name').val(lastName);
        $('#email').val(email);
        $('#phone').val(phone);
        $('#address').val(address);
        $('#city').val(city);
        $('#user_id').val(user_id);
        
         Close the modal
        $('#userModal').modal('hide');
    });

    $(document).ready(function() {
     AJAX call to fetch products
    $.ajax({
        url: 'receipt_products_get.php',  Path to your PHP file
        method: 'GET',
        dataType: 'json',
        success: function(response) {
             Clear the dropdown
            $('#form_id').empty();
             Add each product as an option to the dropdown
            $.each(response, function(index, product) {
                $('#form_id').append($('<option>', {
                    value: product.id,
                    text: product.name,
                    'data-price': product.price  Set data attribute for price
                }));
            });
             Update the price display for the first product
            if (response.length > 0) {
                $('#price').val(response[0].price);  Set the price input field value
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching products:', error);
        }
    });

    $(document).ready(function() {
     AJAX call to fetch services
    $.ajax({
        url: 'receipt_services_get.php',  Path to your PHP file that fetches services
        method: 'GET',
        dataType: 'json',
        success: function(response) {
             Check if response is an array
            if (Array.isArray(response)) {
                 Clear the dropdown
                $('#service_id').empty();
                 Add each service as an option to the dropdown
                response.forEach(function(service) {
                    $('#service_id').append($('<option>', {
                        value: service.id,
                        text: service.name
                    }));
                });
            } else {
                console.error('Invalid response format:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching services:', error);  Log any errors to the console
        }
    });
});


     Event listener for when a different product is selected
    $('#form_id').change(function() {
        var selectedProductId = $(this).val();
        var selectedProductPrice = $(this).find(':selected').data('price');  Get the price from data attribute
        $('#price').val(selectedProductPrice);  Update the price input field value
    });

     Event listener for the "Add" button
    $('#add_product_row').click(function() {
         Retrieve selected product ID, quantity, and price
        var productId = $('#form_id').val();
        var quantity = $('#qty').val();
        var price = $('#price').val();
        
         Send data to server-side script for insertion
        $.ajax({
            url: 'receipt_product_insert.php',  Replace 'insert_product.php' with your server-side script
            method: 'POST',
            data: {
                productId: productId,
                quantity: quantity,
                price: price
            },
            success: function(response) {
                 Handle success (if needed)
                console.log('Product added successfully:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                 Handle error (if needed)
                console.error('Error adding product:', error);
            }
        });
    });
});


$(document).ready(function() {
     Event listener for the "Add" button
    $('#add_product_row').click(function() {
         Retrieve selected product ID, quantity, and calculate cost
        var productId = $('#form_id').val();
        var quantity = $('#qty').val();
        var cost = $('#cost').val();
        
         Validate inputs
        if (!productId || !quantity || quantity < 1) {
            alert('Please select a product and enter a valid quantity.');
            return;
        }
        
         Calculate cost
        var cost = parseFloat($('#form_id option:selected').data('price')) * quantity;
        
         Prepare data to send to server
        var data = {
            receipt_id: <?php echo $current_receipt_id; ?>,  Assuming $latest_receipt_id contains the current receipt ID
            productId: productId,
            quantity: quantity,
            cost: cost
        };
        
         Send data to server-side script for insertion
        $.ajax({
            url: 'receipt_product_insert.php',
            method: 'POST',
            data: data,
            success: function(response) {
                 Handle success
                console.log('Product added successfully:', response);
                location.reload();
                 Optional: You can update the UI to reflect the added product if needed
            },
            error: function(xhr, status, error) {
                 Handle error
                console.error('Error adding product:', error);
            }
        });
    });
});

$(document).ready(function() {
     Event listener for the "Add" button for services
    $('#add_service_row').click(function() {
         Retrieve selected service name, cost, and receipt_id
        var serviceID = $('#service_id').val();
        var serviceCost = $('#service_cost').val();
        var receiptId = <?php echo $current_receipt_id; ?>;  Assuming $current_receipt_id contains the current receipt ID
        
         Validate inputs
        if (!serviceID || !serviceCost || serviceCost < 0) {
            alert('Please enter a valid service name and cost.');
            return;
        }
        
         Prepare data to send to server
        var data = {
            serviceId: serviceID,
            receipt_id: receiptId,
            cost: serviceCost
        };
        
         Send data to server-side script for insertion
        $.ajax({
            url: 'receipt_service_insert.php',  Replace with the path to your PHP file handling the insertion
            method: 'POST',
            data: data,
            success: function(response) {
                 Handle success
                console.log('Service added successfully:', response);
                location.reload();
                 Optional: You can update the UI to reflect the added service if needed
            },
            error: function(xhr, status, error) {
                 Handle error
                console.error('Error adding service:', error);
            }
        });
    });
});

$(document).ready(function() {

  Function to update total amount
function updateProductsTotalAmount() {
    var total = 0;
     Iterate through each row in the table
    $('#products_table tbody tr').each(function() {
         Extract cost from the current row and remove the dollar sign
        var cost = parseFloat($(this).find('td:eq(2)').text().replace('$', ''));
         Add cost to the total
        total += cost;
    });
     Update the total amount displayed
    $('#products_total_amount').text('₱' + total.toFixed(2));  Add the dollar sign back and round to 2 decimal places
}

     Call updateTotalAmount initially to set the total amount to 0
    updateProductsTotalAmount();

    function updateServicesTotalAmount() {
    var total = 0;
     Iterate through each row in the table
    $('#services_table tbody tr').each(function() {
         Extract cost from the current row and remove the dollar sign
        var cost = parseFloat($(this).find('td:eq(1)').text().replace('$', ''));
         Add cost to the total
        total += cost;
    });
     Update the total amount displayed
    $('#services_total_amount').text('₱' + total.toFixed(2));  Add the dollar sign back and round to 2 decimal places
}
updateServicesTotalAmount();

    $('.delete-product').click(function() {
        var button = $(this);  Store reference to the button element
        
        var receiptProductId = button.data('receipt-product-id');
        
             Send AJAX request to delete the product
            $.ajax({
                url: 'receipt_product_delete.php',  Replace with the path to your PHP file handling the deletion
                method: 'POST',
                data: {
                    receiptProductId: receiptProductId
                },
                success: function(response) {
                     Refresh the page or update the table as needed
                     For example, you can remove the row from the table
                    if (response === 'success') {
                        button.closest('tr').remove();  Remove the row from the table using the stored button reference
                        alert('Product deleted successfully.');
                        location.reload();
                    } else {
                        console.log('Failed to delete product. Please try again.');
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting product:', error);
                    alert('An error occurred while deleting the product. Please try again.');
                }
            });
    });
});

$('.delete-service').click(function() {
        var button = $(this);  Store reference to the button element
        
        var receiptServiceId = button.data('receipt-service-id');
             Send AJAX request to delete the product
            $.ajax({
                url: 'receipt_service_delete.php',  Replace with the path to your PHP file handling the deletion
                method: 'POST',
                data: {
                    receiptServiceId: receiptServiceId
                },
                success: function(response) {
                     Refresh the page or update the table as needed
                     For example, you can remove the row from the table
                    if (response === 'success') {
                        button.closest('tr').remove();  Remove the row from the table using the stored button reference
                        alert('Service deleted successfully.');
                        location.reload();
                    } else {
                        console.log('Failed to delete service. Please try again.');
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting service:', error);
                    alert('An error occurred while deleting the service. Please try again.');
                }
            });
    });

    $(document).ready(function() {
    $('#submitReceipt').click(function() {
         Retrieve the grand total value
        var grandTotal = parseFloat($('#grand_total').text().replace('₱', '').replace(',', ''));

         Retrieve other necessary data from the inputs
        var currentReceiptId = $('#receipt_id').val();  Assuming you have an input field with ID currentReceiptId

         Prepare data to send to server
        var data = {
            grandTotal: grandTotal,
            currentReceiptId: currentReceiptId
        };

         Send AJAX request to update the receipt and generate PDF
        $.ajax({
            url: 'receipt_admin_submit.php',
            method: 'POST',
            data: data,
            success: function(response) {
                 Handle success
                console.log('Receipt saved successfully:', response);
                 Optionally, perform any additional actions after updating
                generatePDF();
            },
            error: function(xhr, status, error) {
                 Handle error
                console.error('Error updating receipt:', error);
            }
        });
    });
});

function generatePDF() {
     Send AJAX request to generate PDF
    $.ajax({
        url: 'receipt_print.php',
        method: 'POST',
        data: {
             Pass any additional data needed for generating PDF
            grandTotal: parseFloat($('#grand_total').text().replace('₱', '').replace(',', '')),
            currentReceiptId: $('#receipt_id').val()  Assuming you have an input field with ID currentReceiptId
        },
        success: function(pdfUrl) {
             Display the PDF to the user
            window.open(pdfUrl, '_blank');  Open PDF in a new tab
        },
        error: function(xhr, status, error) {
            console.error('Error generating PDF:', error);
        }
    });
}

</script>

</body>
</html>