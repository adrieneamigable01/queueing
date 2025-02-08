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
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if 'serving_id' and 'isAnnounce' are provided in the request
if (isset($_POST['serving_id']) && isset($_POST['isAnnounce'])) {
    $serving_id = $_POST['serving_id'];
    $isAnnounce = $_POST['isAnnounce']; // 0 for not announced, 1 for announced

    // Update the 'isAnnounce' field in the 'serving' table
    $sql = "UPDATE serving SET isAnnounce = :isAnnounce WHERE serving_id = :serving_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':isAnnounce', $isAnnounce, PDO::PARAM_INT);
    $stmt->bindParam(':serving_id', $serving_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Announcement status updated.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update announcement status.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Required parameters are missing.']);
}
?>
