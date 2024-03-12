<?php
session_start();
  if (!isset($_SESSION['user_id'])) {
      header("Location: user_login.php");
      exit();
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Time Slots</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .containerSlots{
        text-align: center;
        background-color: gold;
        color: black;
    }
    .timeSlots {
        max-width: 1000px;
        text-align: center;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        margin-top: 100px;
    }
    .slot {
    width: calc(100% / 4 - 20px);
    background-color: #52f222;
    border: 1px solid #ccc;
    margin: 10px;
    padding: 15px;
    box-sizing: border-box;
    transition: background-color 0.3s, box-shadow 0.3s; /* Add transition for smooth hover effect */
    }

    .slot:hover {
        background-color: lightgreen; /* Change background color on hover */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add shadow on hover */
        transform: translateY(-3px) scale(1.1);
    }

    #verifyButton{
        background-color: black;
    }
</style>
</head>
<body>
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>SELECT A TIME SLOT</h2>
      <ol>
        <li><a href="./event-full-calendar_user.php">Calendar</a></li>
        <li>Appointment</li>
      </ol>
    </div>

  </div>
</section>
<div class="containerSlots">
<?php
require 'connection.php';

// Fetch event details including num_time_slots
$event_id = $_GET['event_id']; // Assuming you're passing the event_id via GET parameter

$query = "SELECT num_time_slots FROM calendar_event_master WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the event exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $num_time_slots = $row['num_time_slots'];
    
    // Output the num_time_slots within the HTML
    echo '<div class="containerSlots">';
    echo '<h2>Available Slots: ' . $num_time_slots . '</h2>';
    echo '</div>';
} else {
    echo "Event not found.";
}
?>
</div>
    <div class="timeSlots">
<?php
require 'connection.php';

// Fetch event start and end times from database based on event_id
$event_id = $_GET['event_id']; // Assuming you're passing the event_id via GET parameter

// Query the appointment table to retrieve booked time slots for the selected event
$query = "SELECT start_time, end_time FROM appointment WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Store booked time slots in an array
$booked_slots = array();
while ($row = $result->fetch_assoc()) {
    $booked_slots[] = array(
        'start_time' => strtotime($row['start_time']),
        'end_time' => strtotime($row['end_time'])
    );
}

// Fetch event start and end times from database based on event_id
$query = "SELECT duration, event_start_time, event_end_time FROM calendar_event_master WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $start_time = strtotime($row['event_start_time']);
    $end_time = strtotime($row['event_end_time']);
    $duration = $row['duration'];
    // Loop through time slots with 30-minute intervals
    while ($start_time < $end_time) {
        $slot_start = date('h:iA', $start_time);
        $slot_end = date('h:iA', strtotime('+' . $duration . ' minutes', $start_time));
        echo '<button class="slot">' . $slot_start . ' - ' . $slot_end . '</button>';
        $start_time = strtotime('+' . $duration . ' minutes', $start_time);
    }
}
?>

    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<title>Appointment</title>
<!-- *Note: You must have internet connection on your laptop or pc other wise below code is not working -->
<!-- CSS for full calender -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calender -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<?php
    include "header.html";
?>
<main id="main">

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div id="calendar"></div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="uploads/step-1.png" alt="" height="70px" width="70px">
                <h3 class="modal-title" id="modalLabel1"><b>Appointment Information</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <input type="hidden" id="user_id" class="form-control" readonly>
    <input type="hidden" id="selectedTime">
    <input type="hidden" id="event_id" class="form-control" readonly>
    <label for="event_start_date">Date:</label>
    <input type="date" id="event_start_date" class="form-control" readonly>
    <label for="event_start_time">Start Time:</label>
    <input type="text" id="event_start_time" class="form-control" readonly>
    <input type="hidden" id="event_end_date" class="form-control" readonly>
    <label for="event_end_time">End Time:</label>
    <input type="text" id="event_end_time" class="form-control" readonly>
    <label for="service">Select Service:</label>
    <select id="service" class="form-control">
        <!-- PHP code to fetch services from database and populate options -->
        <?php
        require 'connection.php';
        $query = "SELECT * FROM services"; // Assuming 'services' is the name of your services table
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['ServiceID'] . '">' . $row['ServiceName'] . '</option>';
            }
        }
        ?>
        <!-- End of PHP code -->
    </select>
</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="nextModal">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Confirm Information -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="uploads/step-2.png" alt="" height="70px" width="70px">
                <h3 class="modal-title" id="modalLabel"><b>Confirm Information</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selectedTime">
                <div class="mb-3">
                <input type="hidden" id="user_id2" class="form-control" readonly>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control" readonly>
                </div>
                
                <div class="mb-3">
                    <h5><b>Reservation Fee</b></h5>
                    <p>Price: ₱200.00</p>
                </div>
                
                <div class="mb-3">
                <h5><b>Terms and Conditions</b></h5>
                <p>By proceeding with this appointment, you agree to the following terms and conditions:</p>
                <ul>
                <li>A reservation fee of ₱200.00 is required to secure your appointment.</li>
                <li>This reservation fee is non-refundable.</li>
                <li>If you cancel your appointment, you forfeit the reservation fee.</li>
                </ul>
                <label for="agreeCheckbox">
                <input type="checkbox" id="agreeCheckbox" onchange="toggleSubmitButton()"> I agree to the terms and conditions
                </label>
                <br><p class="text-center">Want to update your profile? <a href="user_profile.php">Update Here</a></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal2" onclick="showModal1()">Back</button>
                <button type="button" class="btn btn-primary" id="nextButton" onclick="showModal3()"disabled>Next</button>
            </div>
        </div>
    </div>
</div>
<!-- End popup dialog box -->

<!-- Modal 3 -->
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="uploads/step-3.png" alt="" height="70px" width="70px">
                <h3 class="modal-title" id="modalLabel"><b>Payment</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selectedTime">
                <h3></b>Payment Method</b></h3>
                <div class="checkboxLogo">
                <input type="hidden" id="user_id3" class="form-control" readonly placeholder="User ID">
                <label><input type="checkbox" id="gcashCheckbox" onclick="handleCheckboxClick('gcashCheckbox')"> <img src="uploads/gcash.png" alt="gcash icon" height="50px" width="130px"></label>
                <label><input type="checkbox" id="paypalCheckbox" onclick="handleCheckboxClick('paypalCheckbox')"> <img src="uploads/paypal.png" alt="paypal icon" height="40px" width="130px"></label>
                <label><input type="checkbox" id="cliqqCheckbox" onclick="handleCheckboxClick('cliqqCheckbox')"> <img src="uploads/cliqq.png" alt="cliqq icon" height="30px" width="120px"></label>
                </div>
                <div class="mb-3">
                    <label for="phone">Account ID:</label>
                    <input type="password" id="account_id" class="form-control" placeholder="Enter Account ID">
                    <button type="button" class="btn btn-secondary" id="verifyButton" onclick="verifyAccount()"><i class="fa fa-check" aria-hidden="true"></i></button>
                    <!-- <img src="uploads/verified.png" id="verified" alt="verified" height="20px" width="20px"> -->
                </div>
                <div class="mb-3">
                    <label for="email">Balance:</label>
                    <input type="input" id="balance" class="form-control" readonly placeholder="Balance">
                    <input type="hidden" id="user_id" class="form-control" readonly placeholder="User ID">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal2" onclick="showModal2()">Back</button>
                <button type="button" class="btn btn-success" id="submitAppointment" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- End popup dialog box -->
<br>
</main>
<br>
<?php
    include "footer.html";
?>
</body>

<script>

$(document).ready(function() {
    // Retrieve the URL parameters
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const eventId = urlParams.get('event_id');
    const startDate = urlParams.get('start_date');
    const endDate = urlParams.get('end_date');
    const userId = urlParams.get('user_id');
    $('#user_id').val(userId);
    $('#event_id').val(eventId);
    $('#event_start_date').val(startDate);
    $('#event_end_date').val(endDate);
});


$(document).ready(function() {
    $('#nextModal').on('click', function() {
        $.ajax({
            url: 'get_user_id.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var userId = response.user_id;
                showModal2(userId);
            },
            error: function(xhr, status, error) {
                console.error('Error retrieving user ID:', error);
            }
        });
    });

    $('.slot').on('click', function() {
        var timeSlot = $(this).text().trim();
        $('#selectedTime').val(timeSlot);
        showModal1();
    });
});

function showModal1() {
    $('#modal2').modal('hide');
    $('#modal1').modal('show');
    var timeSlot = $('#selectedTime').val();
    var timeRange = timeSlot.split(" - ");
    var startTime = timeRange[0];
    var endTime = timeRange[1];
    var urlParams = new URLSearchParams(window.location.search);
    var eventId = urlParams.get('event_id');
    var startDate = urlParams.get('start_date');
    var endDate = urlParams.get('end_date');
    var userId = urlParams.get('user_id');

    document.getElementById('user_id').value = userId;
    document.getElementById('event_id').value = eventId;
    document.getElementById('event_start_date').value = startDate;
    document.getElementById('event_end_date').value = endDate;
    document.getElementById('event_start_time').value = startTime;
    document.getElementById('event_end_time').value = endTime;
}

function showModal2(userId) {
    $('#modal1').modal('hide');
    $('#modal3').modal('hide');
    $('#modal2').modal('show');

$.ajax({
    url: 'fetch_user_info.php',
    type: 'POST',
    dataType: 'json',
    data: { user_id: userId },
    success: function(response) {
        if (response.status) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var userId = urlParams.get('user_id');
            var userInfo = response.data;
            $('#first_name').val(userInfo.first_name);
            $('#last_name').val(userInfo.last_name);
            $('#phone').val(userInfo.phone);
            $('#email').val(userInfo.email);
            $('#user_id2').val(userId);
            $('#modal2').modal('show');
        } else {
            console.log('Error: ' + response.msg);
        }
    },
    error: function(xhr, status) {
        console.log('Error fetching user info');
    }
});
}

function showModal3(event, userId) {
    $('#modal2').modal('hide');
    $('#modal1').modal('hide');
    $('#modal3').modal('show');
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var userId = urlParams.get('user_id');
    $('#user_id3').val(userId);
}

function toggleSubmitButton() {
  var agreeCheckbox = document.getElementById("agreeCheckbox");
  var nextButton = document.getElementById("nextButton");

  if (agreeCheckbox.checked) {
    nextButton.disabled = false;
  } else {
    nextButton.disabled = true;
  }
}

function disableVerifyButton() {
    var verifyButton = document.getElementById('verifyButton');
    verifyButton.addEventListener('click', function() {
        var balanceInput = document.getElementById('balance');
        
        if (balanceInput.value !== '') {
            verifyButton.disabled = true;
        }
    });
}

function handleCheckboxClick(clickedCheckboxId) {
  var gcashCheckbox = document.getElementById("gcashCheckbox");
  var paypalCheckbox = document.getElementById("paypalCheckbox");
  var cliqqCheckbox = document.getElementById("cliqqCheckbox");
  var accountIdInput = document.getElementById("account_id");

  if (clickedCheckboxId === "gcashCheckbox" && gcashCheckbox.checked) {
    accountIdInput.value = "";
    paypalCheckbox.checked = false;
    cliqqCheckbox.checked = false;
  } else if (clickedCheckboxId === "paypalCheckbox" && paypalCheckbox.checked) {
    accountIdInput.value = "";
    gcashCheckbox.checked = false;
    cliqqCheckbox.checked = false;
  } else if (clickedCheckboxId === "cliqqCheckbox" && cliqqCheckbox.checked) {
    accountIdInput.value = "";
    gcashCheckbox.checked = false;
    paypalCheckbox.checked = false;
  }
}

function verifyAccount() {
  var accountIdInput = document.getElementById("account_id");
  var balanceInput = document.getElementById("balance");
  var accountId = accountIdInput.value.trim();
  var gcashCheckbox = document.getElementById("gcashCheckbox");
  var paypalCheckbox = document.getElementById("paypalCheckbox");
  var cliqqCheckbox = document.getElementById("cliqqCheckbox");
  var verifiedAccount = document.getElementById("verified");

  if (accountId !== "" ) {
    var randomBalance = Math.floor(Math.random() * 10000) + 1;
    balanceInput.value = randomBalance;
    accountIdInput.disabled = true;
  }else if(!gcashCheckbox.checked && !paypalCheckbox.checked && !cliqqCheckbox.checked){
    alert("Please choose a payment platform");
  }else{
    alert("Please enter an Account ID");
  }
}
disableVerifyButton();

function submitForm() {
    var eventId = $('#event_id').val();
    var userId = $('#user_id3').val();
    var balance = $('#balance').val();
    var startTime = $('#event_start_time').val();
    var endTime = $('#event_end_time').val();
    var serviceId = $('#service').val();

    console.log("Event ID:", eventId);
    console.log("User ID:", userId);
    console.log("Balance:", balance);
    console.log("Start Time:", startTime);
    console.log("End Time:", endTime);
    console.log("Service ID:", serviceId);

    $.ajax({
        url: 'event_booked_status_user.php', 
        type: 'POST',
        dataType: 'json',
        data: { 
            eventId: eventId, 
            userId: userId, 
            balance: balance, 
            startTime: startTime, 
            endTime: endTime, 
            serviceId: serviceId
         },
        success: function(response) {
            if (response.status) {
                alert(response.msg);
                window.location.href = "./event-full-calendar_user.php";
            } else {
                alert('Failed to update event name');
            }
        },
        error: function(xhr, status) {
            console.log('Error occurred while updating event name');
        }
    });
}
</script>
</html> 
