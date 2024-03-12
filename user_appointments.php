<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Appointment</title>
</head>
<style>
    .table-fill { 
        margin-left: 250px;
        margin-top: 50px;
        margin-bottom: 50px;
    }
</style>
<body>
    <?php
    include "sidebar.html";
    include "connection.php";


    $sql = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
            FROM calendar_event_master ce 
            INNER JOIN appointment a ON ce.event_id = a.event_id WHERE status = 'Success'" ;


$sql1 = "SELECT ce.event_start_date, ce.event_end_date, a.start_time, a.end_time, a.status 
FROM calendar_event_master ce 
INNER JOIN appointment a ON ce.event_id = a.event_id WHERE status = 'pending'" ;

  
$result1 = mysqli_query($conn, $sql1);
    $result = mysqli_query($conn, $sql);
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
<div>     
    <h1>


    <?php
            if (mysqli_num_rows($result1) > 0) {
                while ($rows = mysqli_fetch_assoc($result1)) {
                    
                    echo "<h3 class=text-center>" . $rows["status"] . "</h3>";
                    echo "<h2 class=text-center>" . $rows["event_start_date"] . "</h1>";
                    echo "<h1 class=text-center>" . $rows["start_time"] . "-" . $rows["end_time"] . "</h1>";
                }
            } else {
                echo "<h1>colspan='5'>No records found</h1>";
            }
            // mysqli_close($conn);
            ?>
  
  </h1>

  </div>
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
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class=text-center>" . $row["event_start_date"] . "</td>";
                    echo "<td class=text-center>" . $row["event_end_date"] . "</td>";
                    echo "<td class=text-center>" . $row["start_time"] . "</td>";
                    echo "<td class=text-center>" . $row["end_time"] . "</td>";
                    echo "<td class=text-center>" . $row["status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>
