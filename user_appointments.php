<?php
    session_start();
    include "connection.php";

    if(!isset($_SESSION['user_id'])) {
        header("Location: user_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">


    <link href="assets/css/style.css" rel="stylesheet">

</head>
<style>
    .table-fill { 
        margin: auto;
    }
    .statusContainer {
    background-color: gold;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: fit-content;
    margin-left: 83%;
    position: fixed;
    display: block;
    }
    .tableContainer{
        padding: 20px;
    }
</style>
<body>

<!-- Modal: Terms and Conditions -->
<div class="modal fade" id="modalTerms" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your terms and conditions content here -->
                <label for="appointmentId">Appointment ID:</label>
                <input type="text" id="appointmentId" name="appointmentId">
                <p>By proceeding with this appointment, you agreed to the following terms and conditions:</p>
                <ul>
                    <li>A reservation fee of 10% of your chosen service is required to secure your appointment.</li>
                    <li>This reservation fee is non-refundable.</li>
                    <li>If you cancel your appointment, you forfeit the reservation fee.</li>
                    <hr>
                    <h5>Do you really want to cancel the booked slot?</h5>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary confirm-button">Confirm</button>
            </div>
        </div>
    </div>
</div>


    <?php
    include "sidebaruser.html";
    ?>

    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Appointments</h2>
                <ol>
                    <li><a href="ui.php">Home</a></li>
                    <li>Appointments</li>
                </ol>
            </div>
        </div>
    </section>
    <br>
    <div class="statusContainer">
    <h3>Pending</h3>
    <?php
    $loggedInUserId = $_SESSION['user_id'];

    // Query for status pending
    $sqlPending = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status, a.appointment_id
                   FROM calendar_event_master ce 
                   INNER JOIN appointment a ON ce.event_id = a.event_id 
                   WHERE a.status = 'Pending' AND a.user_id = ?";
    $stmtPending = $conn->prepare($sqlPending);
    $stmtPending->bind_param("i", $loggedInUserId);
    $stmtPending->execute();
    $resultPending = $stmtPending->get_result();

    // Display the result for status pending (text)
    if ($resultPending->num_rows > 0) {
        while ($row = $resultPending->fetch_assoc()) {
            // Convert start time to 12-hour format
            $startTime = date('h:i A', strtotime($row["start_time"]));
            // Convert end time to 12-hour format
            $endTime = date('h:i A', strtotime($row["end_time"]));
            
            echo "<p>Event Date: " . $row["event_start_date"] . "</p>";
            echo "<p>Time: " . $startTime . " - " . $endTime . "</p>";
            echo '<button class="btn btn-secondary mr-2 bg-danger" onclick="showModal(' . $row['appointment_id'] . ')">Cancel</button>';
        }
        } else {
        echo "<p>No pending appointments found for user ID: " . $loggedInUserId . "</p>";
    }
    ?>
</div>
<div class="tableContainer">
  <br>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">Start Date</th> 
                <th class="text-center">End Date</th> 
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody class="table-hover">
    <?php
        $sqlSuccess = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
                    FROM calendar_event_master ce 
                    INNER JOIN appointment a ON ce.event_id = a.event_id 
                    WHERE a.status = 'Success' AND a.user_id = ?";
        $stmtSuccess = $conn->prepare($sqlSuccess);
        $stmtSuccess->bind_param("i", $loggedInUserId);
        $stmtSuccess->execute();
        $resultSuccess = $stmtSuccess->get_result();

        if ($resultSuccess->num_rows > 0) {
            while ($row = $resultSuccess->fetch_assoc()) {
                echo "<tr>";
                echo "<td class=text-center>" . $row["event_start_date"] . "</td>";
                echo "<td class=text-center>" . $row["event_end_date"] . "</td>";
                echo "<td class=text-center>" . $row["start_time"] . "</td>";
                echo "<td class=text-center>" . $row["end_time"] . "</td>";
                echo "<td class=text-center>" . $row["status"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No successful appointments found for user ID: " . $loggedInUserId . "</p>";
        }
?>

        </tbody>
    </table>
</div>
</body>

<script>
function showModal(appointmentId) { 
    $('#appointmentId').val(appointmentId);
    $('#modalTerms').modal('show');
}

$(document).ready(function() {
    $('.confirm-button').on('click', function() {
        var appointmentId = $('#appointmentId').val();

        $.ajax({
            url: 'event_cancel_user.php',
            method: 'POST',
            data: { appointment_id: appointmentId },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});



</script>

</html>
