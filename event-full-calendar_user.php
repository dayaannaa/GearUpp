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
</head>
<body>
<!-- <?php
  /* session_start();
  if (!isset($_SESSION['user_id'])) {
      header("Location: user_login.php");
      exit();
  } */
?> -->
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <h5 align="center">Appointment</h5>
            <div id="calendar"></div>
        </div>
        <div class="col-lg-3">
            <h5 align="center">Legend</h5>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #007bff; color: white;">NO SLOTS</div>
                    <div class="legend-color" style="background-color: #52f222; ">AVAILABLE</div>
                    <div class="legend-color" style="background-color: #dc3545; color: white;">FULLY BOOKED</div>
                    <div class="legend-color" style="background-color: #ffc107; ">HOLIDAY</div>
                </div>
            </div>
            <div class="col-lg-3">
                <br>
            <h5 align="center">Holidays</h5>
            <div class="legend">
                <div class="holiday-item">

                </div>
            </div>
        </div>
        </div>
<!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Appointment Information</h5>
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

<br>
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
                    var clickedEvent = calendar.fullCalendar('clientEvents', function(event) {
                        return (event.start.isSame(start, 'day') && event.end.isSame(end, 'day'));
                    })[0];
                    if (clickedEvent && !isRestrictedEvent(clickedEvent.title)) {
                        $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                        $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                        $('#event_entry_modal').modal('show');
                    }
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

    $('#event_color').spectrum({
        color: "#007bff",
        preferredFormat: "hex",
        showInput: true,
        showPalette: true,
        palette: [
            ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8']
        ]
    });
}

function isRestrictedEvent(eventName) {
    var restrictedEvents = ["No Slots", "Fully Booked", "Holiday"];
    return restrictedEvents.includes(eventName);
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

</script>
</html> 