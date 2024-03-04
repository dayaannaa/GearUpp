<?php
session_start();
  if (!isset($_SESSION['user_id'])) {
      header("Location: user_login.php");
      exit();
  } 
?>
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
    <style>
.available-event {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.available-event:hover {
    transform: translateY(-5px) scale(1.5);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
<?php
    include "header.html";
?>
<main id="main">

<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>SCHEDULE AN APPOINTMENT</h2>
      <ol>
        <li><a href="ui.php">Home</a></li>
        <li>Appointment</li>
      </ol>
    </div>

  </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <!-- <h5 align="center">Appointment</h5> -->
            <br>
            <div id="calendar"></div>
        </div>
        <div class="col-lg-3">
            <br>
            <h5 align="center">Legend</h5>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #007bff; color: white;">NO SLOTS</div>
                    <div class="legend-color" style="background-color: #ffc107; ">PENDING</div>
                    <div class="legend-color" style="background-color: #ff6767; color: white;">BOOKED</div>
                    <div class="legend-color" style="background-color: #d6d6d6; ">HOLIDAY</div>
                    <div class="legend-color" style="background-color: #52f222; ">AVAILABLE</div>
                </div>
            </div>
            <div class="col-lg-3">
                <br>
            <!-- <h5 align="center">Holidays</h5> -->
            <div class="legend">
                <div class="holiday-item">

                </div>
            </div>
        </div>
        </div>
<!-- Start popup dialog box -->

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
                <label for="event_id">ID:</label>
                <input type="text" id="event_id" class="form-control" readonly>
                <label for="event_title">Status:</label>
                <input type="text" id="event_title" class="form-control" readonly>
                <label for="event_start_date">Start Date:</label>
                <input type="date" id="event_start_date" class="form-control" readonly>
                <label for="event_start_time">Start Time:</label>
                <input type="text" id="event_start_time" class="form-control" readonly>
                <label for="event_end_date">End Date:</label>
                <input type="date" id="event_end_date" class="form-control" readonly>
                <label for="event_end_time">End Time:</label>
                <input type="text" id="event_end_time" class="form-control" readonly>
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
                <!-- User Information -->
                <div class="mb-3">
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
                <!-- User Information -->
                <h3></b>Payment Method</b></h3>
                <div class="checkboxLogo">
                <label><input type="checkbox" id="gcashCheckbox" onclick="handleCheckboxClick('gcashCheckbox')"> <img src="uploads/gcash.png" alt="gcash icon" height="50px" width="130px"></label>
                <label><input type="checkbox" id="paypalCheckbox" onclick="handleCheckboxClick('paypalCheckbox')"> <img src="uploads/paypal.png" alt="paypal icon" height="40px" width="130px"></label>
                <label><input type="checkbox" id="cliqqCheckbox" onclick="handleCheckboxClick('cliqqCheckbox')"> <img src="uploads/cliqq.png" alt="cliqq icon" height="30px" width="120px"></label>
                </div>
                <div class="mb-3">
                    <label for="phone">Account ID:</label>
                    <input type="password" id="account_id" class="form-control" placeholder="Enter Account ID">
                    <button type="button" class="btn btn-secondary" id="verifyButton" onclick="verifyAccount()">Verify</button>
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
    display_events();
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
});

function display_events() {
    var events = [];

    $.ajax({
        url: 'event_display_user.php',
        dataType: 'json',
        success: function(response) {
            var result = response.data;
            $.each(result, function(i, item) {
                var event = {
                    event_id: result[i].event_id,
                    title: result[i].title,
                    start: result[i].start,
                    end: result[i].end,
                    event_start_time: result[i].event_start_time,
                    event_end_time: result[i].event_end_time,
                    color: result[i].color,
                    url: result[i].url
                };

                if (event.title === 'Available') {
                    event.className = 'available-event';
                }

                events.push(event);
            });

            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    var clickedEvent = calendar.fullCalendar('clientEvents', function(event) {
                        return (event.start.isSame(start, 'day') && event.end.isSame(end, 'day'));
                    })[0];
                },
                eventClick: function(event) {
                    showModal1(event);
                },
                events: events,
                eventRender: function(event, element, view) {
                    if (isRestrictedEvent(event.title)) {
                        element.css('pointer-events', 'none');
                    }
                }
            });
        },
        error: function(xhr, status) {
            console.log('Error fetching events');
        }
    });
}

function showModal1(event) {
    $('#modal2').modal('hide');
    $('#modal1').modal('show');
    $('#event_id').val(event.event_id);
    $('#event_title').val(event.title);
    $('#event_start_date').val(moment(event.start).format('YYYY-MM-DD'));
    $('#event_end_date').val(moment(event.end).format('YYYY-MM-DD'));
    $('#event_start_time').val(moment(event.event_start_time, 'HH:mm').format('HH:mm A'));
    $('#event_end_time').val(moment(event.event_end_time, 'HH:mm').format('HH:mm A'));
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
            var userInfo = response.data;
            $('#first_name').val(userInfo.first_name);
            $('#last_name').val(userInfo.last_name);
            $('#phone').val(userInfo.phone);
            $('#email').val(userInfo.email);
            $('#user_id').val(userId);
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
}

function isRestrictedEvent(eventName) {
    var restrictedEvents = ["No Slots", "Booked", "Holiday", "Pending"];
    return restrictedEvents.includes(eventName);
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
    var userId = $('#user_id').val();
    var balance = $('#balance').val();
    var eventName = "Booked";
    // alert(eventId + " " + userId + " " + balance);
    $.ajax({
        url: 'event_booked_status_user.php', 
        type: 'POST',
        dataType: 'json',
        data: { eventId: eventId, eventName: eventName, userId: userId, balance: balance },
        success: function(response) {
            if (response.status) {
                alert(response.msg);
                window.location.reload();
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