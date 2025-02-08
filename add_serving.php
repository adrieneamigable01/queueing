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

    try {
        // Create PDO connection
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Check if 'queue_id', 'teller_number', and 'status' are provided in the POST request
    if (isset($_POST['queue_id']) && isset($_POST['teller_number']) && isset($_POST['status'])) {
        $queue_id = $_POST['queue_id']; // The queue ID being served
        $teller_number = $_POST['teller_number']; // The teller number
        $status = $_POST['status']; // The status (e.g., pending or served)

        try {
            // Start a transaction to ensure both updates and insertions happen atomically
            $pdo->beginTransaction();

            // Update the current serving status to "done" if there is an active serving record for the queue
            $update_sql = "UPDATE serving SET status = 'Done' WHERE teller_number = :teller_number AND status != 'Done'";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->bindParam(':teller_number', $teller_number, PDO::PARAM_INT);
            $update_stmt->execute();

            // Insert the new serving record into the 'serving' table
            $insert_sql = "INSERT INTO serving (queue_id, teller_number, status) VALUES (:queue_id, :teller_number, :status)";
            $insert_stmt = $pdo->prepare($insert_sql);
            $insert_stmt->bindParam(':queue_id', $queue_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':teller_number', $teller_number, PDO::PARAM_INT);
            $insert_stmt->bindParam(':status', $status, PDO::PARAM_STR);

            // Execute the query for insertion
            if ($insert_stmt->execute()) {
                // Commit the transaction
                $pdo->commit();
                // Return success response
                echo json_encode(['status' => 'success', 'message' => 'New serving added successfully.']);
            } else {
                // If insertion fails, rollback the transaction
                $pdo->rollBack();
                echo json_encode(['status' => 'error', 'message' => 'Failed to add new serving.']);
            }
        } catch (PDOException $e) {
            // In case of an exception, rollback the transaction
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        // Return error response if parameters are missing
        echo json_encode(['status' => 'error', 'message' => 'Required parameters are missing.']);
    }
?>
