<?php
    // Database connection parameters

    // Database connection parameters
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

    try {
        // Create PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Check if 'queue_type' and 'borrower_id' are provided in the POST request
    if (isset($_POST['queue_type']) && isset($_POST['name'])) {
        $queue_type = $_POST['queue_type']; // The queue type (e.g., counter or teller number)
        $name = $_POST['name']; // The borrower ID

        // Get today's date (e.g., '2025-01-24')
        $today_date = date('Y-m-d');

        // Query the database for the highest queue number for today
        $sql = "SELECT MAX(queue_number) AS max_queue_number FROM queue WHERE DATE(date) = :today_date";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':today_date', $today_date, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_queue_number = $result['max_queue_number'] ? (int)$result['max_queue_number'] : 0;

        // Set the queue number for today (if no records, start from 1)
        $queue_number = $max_queue_number + 1;

        // Insert the new serving record into the 'queue' table
        $insert_sql = "INSERT INTO queue (queue_number, queue_type, name, date) 
                       VALUES (:queue_number, :queue_type, :name, NOW())";
        $insert_stmt = $pdo->prepare($insert_sql);

        // Bind parameters
        $insert_stmt->bindParam(':queue_number', $queue_number, PDO::PARAM_INT);
        $insert_stmt->bindParam(':queue_type', $queue_type, PDO::PARAM_STR);
        $insert_stmt->bindParam(':name', $name, PDO::PARAM_STR);

        // Execute the query and check for success
        if ($insert_stmt->execute()) {
            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'New serving added successfully.', 'queue_number' => $queue_number]);
        } else {
            // Return error response if insertion fails
            echo json_encode(['status' => 'error', 'message' => 'Failed to add new serving.']);
        }
    } else {
        // Return error response if parameters are missing
        echo json_encode(['status' => 'error', 'message' => 'Required parameters are missing.']);
    }
?>
