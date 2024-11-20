<?php

include_once '../database/conn.php';

function fetchMoviesHTML($user_id, $conn)
{
    if ($user_id) {
        try {
            // Fetch movies and their favorite status for the current user
            $stmt = $conn->prepare("
                SELECT np.*, 
                       CASE WHEN f.video_id IS NOT NULL THEN 1 ELSE 0 END AS is_favorited
                FROM now_playing_movies np
                LEFT JOIN favorites f ON f.video_id = np.video_id AND f.user_id = :user_id
            ");
            $stmt->execute(['user_id' => $user_id]);
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($movies) {
                foreach ($movies as $movie) {
                    // Add 'favorited' class if the movie is in favorites
                    $favoritedClass = $movie['is_favorited'] ? 'favorited' : '';
                    echo '
                    <div class="relative max-w-xs bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                        <!-- Favorite Icon -->
                        <img 
                            src="../img/ster.png" 
                            alt="Favorite Icon" 
                            class="absolute top-2 left-2 w-8 h-8 cursor-pointer favorite-icon ' . $favoritedClass . '" 
                            data-video-id="' . htmlspecialchars($movie['video_id'], ENT_QUOTES) . '"
                            onclick="toggleFavorite(event, \'' . htmlspecialchars($movie['video_id'], ENT_QUOTES) . '\')"
                        >
                        
                        <!-- Card Clickable Area -->
                        <a href="film_page.php?film_id=' . urlencode($movie['video_id']) . '" class="block">
                            <img class="w-full h-64 object-cover" src="https://image.tmdb.org/t/p/w500' . htmlspecialchars($movie['poster_path'], ENT_QUOTES) . '" alt="' . htmlspecialchars($movie['title'], ENT_QUOTES) . ' Poster">
                            
                            <div class="p-4">
                                <h3 class="text-lg font-bold">' . htmlspecialchars($movie['title'], ENT_QUOTES) . '</h3>
                                <p class="text-sm text-gray-400">' . htmlspecialchars($movie['release_date'], ENT_QUOTES) . '</p>
                                <p class="text-sm mt-2 line-clamp-2">' . htmlspecialchars($movie['overview'], ENT_QUOTES) . '</p>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-yellow-500 font-semibold">' . htmlspecialchars($movie['vote_average'], ENT_QUOTES) . ' / 10</span>
                                    <span class="text-gray-400">' . htmlspecialchars($movie['vote_count'], ENT_QUOTES) . ' votes</span>
                                </div>
                            </div>
                        </a>
                    </div>';
                }
            } else {
                echo '<p class="text-gray-400">No movies found.</p>';
            }
        } catch (PDOException $e) {
            echo '<p class="text-red-500">Error fetching movies: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>';
        }
    } else {
        echo '<p class="text-red-500">Please log in to see your favorite movies.</p>';
    }
}
