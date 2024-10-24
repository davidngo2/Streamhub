<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-900 text-white">
    <header class="py-6 bg-gray-800 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <img src="../img/logo.png" alt="Streamhub Logo" class="w-32">
            <!-- Navigation -->
            <nav class="flex items-center space-x-6 text-lg font-semibold">
                <a href="#film-grid" class="hover:text-gray-400">Home</a>
                <a href="#film-grid3" class="hover:text-gray-400">TV Shows</a>
                <a href="#film-grid2" class="hover:text-gray-400">Movies</a>
                <a href="#film-grid1" class="hover:text-gray-400">Upcoming</a>
                <a href="#my-list" class="hover:text-gray-400">My List</a>
                <!-- Profile Button -->
                <div class="relative">
                    <button class="focus:outline-none" onclick="toggleDropdown()">
                        <img src="../img/apple.png" alt="Profile"
                            class="w-10 h-10 rounded-full border-2 border-gray-400">
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-xl hidden"
                        id="profileDropdown">
                        <ul>
                            <li><a href="account.php"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a></li>
                            <li><a href="sign_in_up/sign_in.php"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <h1 class="text-4xl font-semibold mb-8">Top 10</h1>
    <div id="slideshow" class="relative mx-auto h-[600px] mb-12 overflow-hidden rounded-lg shadow-lg">
        <?php
        include_once '../database/conn.php';
        $stmt = $conn->prepare("SELECT * FROM top_rated");
        $stmt->execute();
        $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $first = true;
        foreach ($slides as $slide) {
            echo '
                <div class="slide ' . ($first ? 'active' : '') . '" style="background-image: url(https://image.tmdb.org/t/p/original' . $slide['poster_path'] . ');">
                    <div class="info-box">
                        <h2>' . $slide['title'] . '</h2>
                        <p>' . $slide['overview'] . '</p>
                        <div class="info-stats">
                            <span>Popularity: ' . $slide['popularity'] . '</span>
                            <span>Rating: ' . $slide['vote_average'] . ' / 10 (' . $slide['vote_count'] . ' votes)</span>
                        </div>
                        <a href="https://www.youtube.com/watch?v=' . $slide['video_key'] . '" class="watch-trailer" target="_blank">Watch Trailer</a>
                    </div>
                </div>';
            $first = false;
        }

        ?>
        <!-- Navigation buttons -->
        <button id="prev"
            class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 hover:bg-gray-900 text-white p-3 rounded-full shadow-md focus:outline-none transition-transform duration-300 hover:scale-110">&#10094;</button>
        <button id="next"
            class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 hover:bg-gray-900 text-white p-3 rounded-full shadow-md focus:outline-none transition-transform duration-300 hover:scale-110">&#10095;</button>
    </div>

    <!-- Pagination dots -->
    <div class="flex justify-center mt-4 space-x-2">
        <?php for ($i = 0; $i < count($slides); $i++) { ?>
            <span
                class="dot h-3 w-3 bg-gray-400 rounded-full cursor-pointer hover:bg-indigo-500 transition-colors duration-300"></span>
        <?php } ?>
    </div>



    <!-- Movies Section -->
    <div class="container px-4 mx-auto py-8">
        <h1 class="text-4xl font-semibold mb-8">Now On Streamhub</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="film-grid">
            <?php
            $stmt = $conn->prepare("SELECT * FROM now_playing_movies");
            $stmt->execute();
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($movies) {
                foreach ($movies as $movie) {
                    echo '
                    <div class="max-w-xs bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                        <img class="w-full h-64 object-cover" src="https://image.tmdb.org/t/p/w500' . $movie['poster_path'] . '" alt="' . $movie['title'] . '">
                        <div class="p-4">
                            <h3 class="text-lg font-bold">' . $movie['title'] . '</h3>
                            <p class="text-sm text-gray-400">' . $movie['release_date'] . '</p>
                            <p class="text-sm mt-2">' . $movie['overview'] . '</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-yellow-500 font-semibold">' . $movie['vote_average'] . ' / 10</span>
                                <span class="text-gray-400">' . $movie['vote_count'] . ' votes</span>
                            </div>
                            <a href="https://www.youtube.com/watch?v=' . $movie['video_key'] . '" target="_blank" class="mt-4 block text-center text-blue-500 hover:underline">Watch Trailer</a>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-gray-400">No movies found.</p>';
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>

</body>

</html>