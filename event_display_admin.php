<?php                
require 'connection.php'; 

$display_query = "SELECT * FROM calendar_event_master";          
$results = mysqli_query($conn, $display_query);   
$count = mysqli_num_rows($results);  

if ($count > 0) {
    $data_arr = array();
    $i = 1;
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {   
        $event_id = $data_row['event_id'];
        $event_name = $data_row['event_name'];
        $event_start_date = date("Y-m-d", strtotime($data_row['event_start_date']));
        $event_end_date = date("Y-m-d", strtotime($data_row['event_end_date']));
        $event_start_time = date("H:i:s", strtotime($data_row['event_start_time']));
        $event_end_time = date("H:i:s", strtotime($data_row['event_end_time']));
        $event_color = $data_row['event_color'];
        $duration = $data_row['duration'];
        $num_time_slots = $data_row['num_time_slots'];

        $data_arr[$i]['event_id'] = $event_id;
        $data_arr[$i]['title'] = $event_name;
        $data_arr[$i]['start'] = $event_start_date;
        $data_arr[$i]['end'] = $event_end_date;
        $data_arr[$i]['color'] = $event_color;
        $data_arr[$i]['num_time_slots'] = $num_time_slots;
        $data_arr[$i]['event_start_time'] = $event_start_time;
        $data_arr[$i]['event_end_time'] = $event_end_time;
        $data_arr[$i]['duration'] = $duration;
        $data_arr[$i]['num_time_slots'] = $num_time_slots;

        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'Successfully!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'				
    );
}

echo json_encode($data);
?>
