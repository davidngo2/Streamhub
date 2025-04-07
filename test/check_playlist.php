<?php

include_once '../database/conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = json_decode(file_get_contents('php://input'), true)['user_id'];

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS playlist_count FROM playlists WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['playlist_count'];

        echo json_encode(['hasPlaylists' => $count > 0]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
