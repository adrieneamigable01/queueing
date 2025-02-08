<?php
header('Content-Type: application/json');
    
// Allow cross-origin requests from all domains
header('Access-Control-Allow-Origin: *');

// Specify the allowed methods for the request
header('Access-Control-Allow-Methods: GET, POST');

// Allow specific headers from the client side
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Prevent caching to ensure fresh data
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include 'connection.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the queue data from the table and the status from the serving table (only active queues)
$sql = "
   SELECT *
    FROM queue_ads
    WHERE queue_ads.is_active = 1;";
$result = $conn->query($sql);

// Prepare the response array
$queue_ads_data = [];
$response = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $queue_ads_data[] = $row;  // Add each row to the array
        $response = array(
            'isError'=>false,
            'message'=>'Succcess',
            'data'=>$queue_ads_data,
            'date'=>date("Y-m-d H:i:s")
        );
        
    }
} else {
    $response = array(
        'isError'=>false,
        'message'=>'No data',
        'data'=>$queue_data,
        'date'=>date("Y-m-d H:i:s")
    );
}

// Close the connection
$conn->close();

// Return the data as JSON
echo json_encode($response);
?>
