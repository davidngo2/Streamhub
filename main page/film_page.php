<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhub - Movie Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php
include_once('../sign_in_up/checkLogin.php');
include_once('../database/conn.php');
checkLogin();

$user_id = $_SESSION['user_id'] ?? null;

// Get film ID from URL
$film_id = $_GET['film_id'] ?? null;
$movie = null;

if ($film_id) {
    // Fetch movie details from the database
    $stmt = $conn->prepare('SELECT * FROM now_playing_movies WHERE video_id = :id');
    $stmt->execute(['id' => $film_id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<body class="bg-gray-900 text-white">

    <!-- Header -->
    <header class="bg-gray-800 h-24 mb-10 shadow-lg">
        <div class="container mx-auto flex justify-between items-center h-full px-6">
            <!-- Logo -->
            <a href="home.php">
                <img src="../img/logo.png" alt="Streamhub Logo" class="w-32 h-32">
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6 text-lg font-medium">
                <a href="#film-grid" class="hover:text-gray-400 transition">Home</a>
                <a href="#film-grid3" class="hover:text-gray-400 transition">TV Shows</a>
                <a href="#film-grid2" class="hover:text-gray-400 transition">Movies</a>
                <a href="#film-grid1" class="hover:text-gray-400 transition">Upcoming</a>
                <a href="#my-list" class="hover:text-gray-400 transition">My List</a>

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button class="focus:outline-none">
                        <img src="../img/apple.png" alt="Profile" class="w-10 h-10 rounded-full border-2 border-gray-500">
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 py-2 w-48 bg-gray-700 rounded-lg shadow-lg hidden group-hover:block">
                        <ul>
                            <li><a href="account.php" class="block px-4 py-2 text-white hover:bg-gray-600 rounded">Settings</a></li>
                            <li><a href="../sign_in_up/logout.php" class="block px-4 py-2 text-white hover:bg-gray-600 rounded">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Movie Details -->
    <main class="container mx-auto px-6">
        <?php if ($movie) : ?>
            <!-- Trailer -->
            <section class="mt-12">
                <h2 class="text-2xl font-semibold mb-6">Watch Trailer</h2>
                <div>
                    <iframe
                        src="https://www.youtube.com/embed/<?= htmlspecialchars($movie['video_key']) ?>"
                        class="rounded-lg shadow-lg"
                        frameborder="0"
                        width="60%"
                        height="500px"
                        allowfullscreen>
                    </iframe>
                </div>
            </section>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Movie Info -->
                <div>
                    <h1 class="text-4xl font-extrabold mb-6"><?= htmlspecialchars($movie['title']) ?></h1>
                    <p class="text-gray-300 mb-4"><strong>Release Date:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
                    <p class="text-gray-300 mb-4"><strong>Language:</strong> <?= htmlspecialchars($movie['original_language']) ?></p>
                    <p class="text-gray-300 mb-4"><strong>Genres:</strong> <?= htmlspecialchars($movie['genre_names']) ?></p>
                    <p class="mb-6"><?= htmlspecialchars($movie['overview']) ?></p>
                    <p class="text-yellow-500"><strong>Rating:</strong> <?= htmlspecialchars($movie['vote_average']) ?></p>
                    <p>(<?= htmlspecialchars($movie['vote_count']) ?> votes)</p>
                </div>
            </div>
            <div id="filmContainer" class="mt-20">
                <h1 class="text-3xl">Watch Movie</h1>
                <iframe
                    id="filmFrame"
                    src="https://vidsrc.me/"
                    referrerpolicy="origin"
                    width="60%"
                    height="500px"
                    style="border: none;"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        <?php else : ?>
            <p class="text-center text-red-500 mt-12">Movie not found or invalid ID provided.</p>
        <?php endif; ?>
    </main>

    <script>
        // Function to get query parameters from the URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        // Load the film ID from the URL
        function loadFilmFromUrl() {
            const filmId = getQueryParam("film_id");
            if (filmId) {
                const iframe = document.getElementById("filmFrame");
                iframe.src = `https://vidsrc.me/embed/${filmId}`;
            } else {
                document.body.innerHTML = "<h2 class='text-center text-red-500'>Error: No film ID provided in the URL.</h2>";
            }
        }
        loadFilmFromUrl();
    </script>
</body>

</html>
