<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'db_connection.php'; // Ensure this file correctly connects to your database
include 'auth_check.php';   // Validate user session (if required)

// Retrieve and decode the JSON payload
$data = json_decode(file_get_contents('php://input'), true);

// Check if the video ID is provided
if (isset($data['video_id'])) {
    $video_id = htmlspecialchars($data['video_id'], ENT_QUOTES);

    // Assuming user ID is stored in session
    session_start(); // Start session if not already started
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO playlists (user_id, video_id) VALUES (?, ?)");
        if ($stmt->execute([$user_id, $video_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request: video ID missing']);
}
