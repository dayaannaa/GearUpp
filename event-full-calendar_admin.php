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
 <?php
  /* session_start();
  if (!isset($_SESSION['admin_id'])) {
      header("Location: user_login.php");
      exit();
  } */
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
                    <div class="legend-color" style="background-color: #52f222; ">AVAILABLE</div>
                    <div class="legend-color" style="background-color: #dc3545; color: white;">FULLY BOOKED</div>
                    <div class="legend-color" style="background-color: #ffc107; ">HOLIDAY</div>
                </div>
            </div>
        </div>
<!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Date Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-sm-12">  
                            <div class="form-group">
                                <label for="event_name">Status</label>
                                <select name="event_name" id="event_name" class="form-control">
                                    <option value="Fully Booked">No Slots</option>
                                    <option value="Available">Fully Booked</option>
                                    <option value="No Slots">Holiday</option>
                                    <option value="Holidays">Available</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event_color">Color</label>
                        <input type="text" name="event_color" id="event_color" class="form-control" placeholder="Pick a color">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label for="event_start_date">Status Start</label>
                                <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                            </div>
                        </div>
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label for="event_end_date">Status End</label>
                                <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
            </div>
        </div>
    </div>
</div>
<!-- End popup dialog box -->

<!-- Start edit event popup dialog box -->
<div class="modal fade" id="edit_event_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Edit Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="form-group">
                        <label for="edit_event_id">Event ID:</label>
                        <input type="text" name="edit_event_id" id="edit_event_id" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_event_name">Status:</label>
                        <select name="edit_event_name" id="edit_event_name" class="form-control">
                            <option value="No Slots">No Slots</option>
                            <option value="Fully Booked">Fully Booked</option>
                            <option value="Holiday">Holiday</option>
                            <option value="Available">Available</option>
                        </select>                   
                     </div>
                    <div class="form-group">
                        <label for="edit_event_color">Color:</label>
                        <input type="color" name="edit_event_color" id="edit_event_color" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label for="edit_event_start_date">Event Start:</label>
                                <input type="date" name="edit_event_start_date" id="edit_event_start_date" class="form-control" placeholder="Event start date">
                            </div>
                        </div>
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label for="edit_event_end_date">Event End:</label>
                                <input type="date" name="edit_event_end_date" id="edit_event_end_date" class="form-control" placeholder="Event end date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="update_event()">Update Event</button>
            </div>
        </div>
    </div>
</div>
<!-- End edit event popup dialog box -->

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
    var events = new Array();
    $.ajax({
        url: 'event_display_admin.php',  
        dataType: 'json',
        success: function (response) {
            var result = response.data;
            $.each(result, function (i, item) {
                events.push({
                    event_id: result[i].event_id,
                    title: result[i].title,
                    start: result[i].start,
                    end: result[i].end,
                    color: result[i].color,
                    url: result[i].url
                }); 	
            });

            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                    $('#event_entry_modal').modal('show');
                },
                events: events,
                eventRender: function(event, element, view) { 
                    element.bind('click', function() {
                    $('#edit_event_id').val(event.event_id); // Set the event ID
                    $('#edit_event_name').val(event.title);
                    $('#edit_event_start_date').val(moment(event.start).format('YYYY-MM-DD'));
                    $('#edit_event_end_date').val(moment(event.end).format('YYYY-MM-DD'));
                    $('#edit_event_color').val(event.color);
                    $('#edit_event_modal').modal('show');
});

            }
            });
                    // Get the most recent event name
                    var recentEventName = result[result.length - 1].title;

                    // Set the selected option in the dropdown
                    $('#event_name').val(recentEventName);
        },
        error: function (xhr, status) {
            alert(response.msg);
        }
    });

    $('#event_color').spectrum({
        color: "#007bff",
        preferredFormat: "hex",
        showInput: true,
        showPalette: true,
        palette: [
            ['#007bff', '#dc3545', '#ffc107', '#52f222',]
        ]
    });

    $('#edit_event_color').spectrum({
        color: "#007bff",
        preferredFormat: "hex",
        showInput: true,
        showPalette: true,
        palette: [
            ['#007bff', '#dc3545', '#ffc107', '#52f222',]
        ]
    });
}

function save_event() {
    var event_name = $("#event_name").val();
    var event_start_date = $("#event_start_date").val();
    var event_end_date = $("#event_end_date").val();
    var event_color = $("#event_color").val();

    if (event_name == "" || event_start_date == "" || event_end_date == "" || event_color == "") {
        alert("Please enter all required details.");
        return false;
    }

    $.ajax({
        url: "save_event.php",
        type: "POST",
        dataType: 'json',
        data: {
            
            event_name: event_name,
            event_start_date: event_start_date,
            event_end_date: event_end_date,
            event_color: event_color
        },
        success: function(response) {
            $('#event_entry_modal').modal('hide');  
            if (response.status == true) {
                alert(response.msg);
                location.reload();
            } else {
                alert(response.msg);
            }
        },
        error: function(xhr, status) {
            console.log('ajax error = ' + xhr.statusText);
            alert(response.msg);
        }
    });
    return false;
}


function update_event() {
    var event_id = $("#edit_event_id").val(); // Assuming you have an input field with ID edit_event_id to store the event ID
    var event_name = $("#edit_event_name").val();
    var event_color = $("#edit_event_color").val();
    var event_start_date = $("#edit_event_start_date").val();
    var event_end_date = $("#edit_event_end_date").val();

    // Perform validation here if needed

    $.ajax({
        url: "update_event.php",
        type: "POST",
        dataType: 'json',
        data: {
            event_id: event_id,
            event_name: event_name,
            event_color: event_color,
            event_start_date: event_start_date,
            event_end_date: event_end_date
        },
        success: function(response) {
            $('#edit_event_modal').modal('hide');
            if (response.status == true) {
                alert(response.msg);
                location.reload(); // Refresh the page or update the calendar display
            } else {
                alert(response.msg);
            }
        },
        error: function(xhr, status) {
            console.log('ajax error = ' + xhr.statusText);
            alert("Error occurred while updating event.");
        }
    });
    return false;
}


</script>
</html> 