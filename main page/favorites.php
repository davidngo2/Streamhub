<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php
include_once('../sign_in_up/checkLogin.php');
checkLogin();
$user_id = $_SESSION['user_id'] ?? null;
?>

<body class="bg-gray-900 text-white">

    <header class="bg-gray-800 h-24 mb-10 flex items-center">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <img src="../img/logo.png" alt="Streamhub Logo" class="w-32 h-32">

            <!-- Navigation -->
            <nav class="flex items-center space-x-6 text-lg font-semibold">
                <a href="#film-grid" class="hover:text-gray-400">Home</a>
                <a href="#film-grid3" class="hover:text-gray-400">TV Shows</a>
                <a href="#film-grid2" class="hover:text-gray-400">Movies</a>
                <a href="#film-grid1" class="hover:text-gray-400">Upcoming</a>
                <a href="#my-list" class="hover:text-gray-400">My List</a>

                <!-- Profile Button -->
                <div class="relative">
                    <button class="focus:outline-none" id="profileButton">
                        <img src="../img/apple.png" alt="Profile" class="w-10 h-10 rounded-full border-2 border-gray-400">
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-xl hidden" id="profileDropdown">
                        <ul>
                            <li><a href="account.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a></li>
                            <li><a href="../sign_in_up/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Movies Section -->
    <div class="container px-4 mx-auto py-8">
        <h1 class="text-4xl font-semibold mb-8">Now On Streamhub</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="film-grid">
            <?php
            include_once '../database/conn.php';
            $stmt = $conn->prepare("
            SELECT np.video_id, np.title, np.poster_path 
            FROM favorites f
            JOIN now_playing_movies np ON f.video_id = np.video_id
            WHERE f.user_id = :user_id
        ");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($favorites) {
                foreach ($favorites as $favorite) {
                    echo '
                <div class="group relative">
                    <a href="../film_page.php?id=' . $favorite['video_id'] . '">
                        <img src="https://image.tmdb.org/t/p/w500' . $favorite['poster_path'] . '" alt="' . $favorite['title'] . '" class="w-full rounded-lg shadow-lg">
                    </a>
                    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full">
                            <a href="film_page.php?film_id=' . $favorite['video_id'] . '" class="text-white text-lg font-semibold">Watch Now</a>
                        </div>
                    </div>
                </div>
                ';
                }
            } else {
                echo '<p class="text-center text-gray-400">No favorites yet.</p>';
            }
            ?>
        </div>
    </div>
    <script>
        function toggleDropdown(event) {
            event.stopPropagation(); // Prevents the click event from reaching the window.onclick
            const dropdown = document.getElementById("profileDropdown");
            dropdown.classList.toggle("hidden"); // Toggle visibility
        }

        // Add click event listener to profile button
        document.getElementById("profileButton").addEventListener("click", toggleDropdown);

        // Hide dropdown when clicking outside of it
        window.onclick = function (event) {
            const dropdown = document.getElementById("profileDropdown");
            if (!dropdown.classList.contains("hidden") && !event.target.closest("#profileButton") && !event.target.closest("#profileDropdown")) {
                dropdown.classList.add("hidden"); // Hide dropdown if it's visible and click is outside
            }
        };
    </script>
</body>

</html>
