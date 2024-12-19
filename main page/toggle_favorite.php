<?php

session_start();
include_once '../database/conn.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$video_id = $data['video_id'];

try {
    // Check if the favorite already exists
    $stmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND video_id = :video_id");
    $stmt->execute(['user_id' => $user_id, 'video_id' => $video_id]);
    $favoriteExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($favoriteExists) {
        // Remove from favorites if it already exists
        $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = :user_id AND video_id = :video_id");
        $stmt->execute(['user_id' => $user_id, 'video_id' => $video_id]);
        echo json_encode(['success' => true, 'action' => 'removed']);
    } else {
        // Add to favorites if it doesn't exist
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, video_id) VALUES (:user_id, :video_id)");
        $stmt->execute(['user_id' => $user_id, 'video_id' => $video_id]);
        echo json_encode(['success' => true, 'action' => 'added']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
