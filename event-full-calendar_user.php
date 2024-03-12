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
        <li>Calendar</li>
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
                    <div class="legend-color" style="background-color: #ff6767; color: white;">FULLY BOOKED</div>
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
                    color: result[i].color,
                    num_time_slots: result[i].num_time_slots,
                    url: result[i].url
                };

                if (event.title.indexOf('Available') !== -1) {
    // 'Available' is found in the event title
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
                    var loggedInUserId = <?php echo $_SESSION['user_id']; ?>;
                // Check if loggedInUserId is not null or undefined before constructing the URL
                if (loggedInUserId !== null && loggedInUserId !== undefined) {
                    if (!isRestrictedEvent(event.title)) {
                    var url = 'slots.php?event_id=' + event.event_id +
                            '&start_date=' + moment(event.start).format('YYYY-MM-DD') +
                            '&end_date=' + moment(event.end).format('YYYY-MM-DD') +
                            '&user_id=' + loggedInUserId;
                    window.location.href = url; // Redirect to slots.php with the constructed URL
                }
            }
                },
                events: events,
                eventRender: function(event, element, view) {
                    if (isRestrictedEvent(event.event_start_date)) {
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



function isRestrictedEvent(eventName) {
    var restrictedEvents = ["No Slots", "Fully Booked", "Holiday", "Pending"];
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

</script>
</html> 