<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>

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
<style>
    .table-fill { 
        margin: auto;
    }
</style>
<body>
    <?php
    include "sidebar.html";
    include "connection.php";


    $sql = "SELECT a.appointment_id, CONCAT(u.first_name, ' ', u.last_name) AS name, ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
    FROM calendar_event_master ce 
    INNER JOIN appointment a ON ce.event_id = a.event_id 
    INNER JOIN user_info u ON a.user_id = u.user_id
    WHERE a.status = 'Success'";

    $sql1 = "SELECT a.appointment_id, CONCAT(u.first_name, ' ', u.last_name) AS name, ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
    FROM calendar_event_master ce 
    INNER JOIN appointment a ON ce.event_id = a.event_id 
    INNER JOIN user_info u ON a.user_id = u.user_id
    WHERE a.status = 'Pending'";

    $sql2 = "SELECT a.appointment_id, CONCAT(u.first_name, ' ', u.last_name) AS name, ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
    FROM calendar_event_master ce 
    INNER JOIN appointment a ON ce.event_id = a.event_id 
    INNER JOIN user_info u ON a.user_id = u.user_id
    WHERE a.status = 'Failed'";

    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);
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

    <div class="tablePending">     
    <h4 class="text-center">Pending</h4>
    <p class="text-center">The appointment time has not yet come. Choose action to make.</p>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th> 
                <th class="text-center">Name</th> 
                <th class="text-center">Start Date</th> 
                <th class="text-center">End Date</th> 
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php
            if (mysqli_num_rows($result1) > 0) {
                while ($rows = mysqli_fetch_assoc($result1)) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $rows["appointment_id"] . "</td>";
                    echo "<td class='text-center'>" . $rows["name"] . "</td>";
                    echo "<td class='text-center'>" . $rows["event_start_date"] . "</td>";
                    echo "<td class='text-center'>" . $rows["event_end_date"] . "</td>";
                    echo "<td class='text-center'>" . $rows["start_time"] . "</td>";
                    echo "<td class='text-center'>" . $rows["end_time"] . "</td>";
                    echo "<td class='text-center'>" . $rows["status"] . "</td>";
                    echo "<td class='text-center'>";
                    echo "<button class='btn btn-success btn-sm' onclick='approveAppointment(" . $rows['appointment_id'] . ")'><i class='fa fa-check'></i></button>";
                    echo "<button class='btn btn-danger btn-sm' onclick='disapproveAppointment(" . $rows['appointment_id'] . ")'><i class='fa fa-times'></i></button>";                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<br>

  <div class= "tableSuccess">  
    <h4 class="text-center">Success</h4>
    <p class="text-center">Customer successfully met the appointed schedule.</p>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th> 
                <th class="text-center">Name</th> 
                <th class="text-center">Start Date</th> 
                <th class="text-center">End Date</th> 
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $row["appointment_id"] . "</td>";
                    echo "<td class='text-center'>" . $row["name"] . "</td>";
                    echo "<td class=text-center>" . $row["event_start_date"] . "</td>";
                    echo "<td class=text-center>" . $row["event_end_date"] . "</td>";
                    echo "<td class=text-center>" . $row["start_time"] . "</td>";
                    echo "<td class=text-center>" . $row["end_time"] . "</td>";
                    echo "<td class=text-center>" . $row["status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<br>
<div class= "tableFailed">  
    <h4 class="text-center">Failed</h4>
    <p class="text-center">Customer failed to meet the appointed schedule.</p>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th> 
                <th class="text-center">Name</th> 
                <th class="text-center">Start Date</th> 
                <th class="text-center">End Date</th> 
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php
            if (mysqli_num_rows($result2) > 0) {
                while ($rowss = mysqli_fetch_assoc($result2)) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $rowss["appointment_id"] . "</td>";
                    echo "<td class='text-center'>" . $rowss["name"] . "</td>";
                    echo "<td class=text-center>" . $rowss["event_start_date"] . "</td>";
                    echo "<td class=text-center>" . $rowss["event_end_date"] . "</td>";
                    echo "<td class=text-center>" . $rowss["start_time"] . "</td>";
                    echo "<td class=text-center>" . $rowss["end_time"] . "</td>";
                    echo "<td class=text-center>" . $rowss["status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<script>
    function approveAppointment(appointmentId) {
        var status = "Success";
        $.ajax({
            url: 'manage_appointment_history_update.php',
            method: 'POST',
            data: { appointmentId: appointmentId, status: 'Success' },
            success: function(response) {
                // Handle success response
                console.log(response);
                alert("Appointment Done Successfully");
                // Reload the page or update UI as needed
                location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error:', error);
            }
        });
    }

    function disapproveAppointment(appointmentId) {
        // Send AJAX request to update the appointment status
        $.ajax({
            url: 'manage_appointment_history_update.php',
            method: 'POST',
            data: { appointmentId: appointmentId, status: 'Failed' },
            success: function(response) {
                // Handle success response
                console.log(response);
                alert("Appointment Failed");
                // Reload the page or update UI as needed
                location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error:', error);
            }
        });
    }
</script>
