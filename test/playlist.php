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
include_once 'fetch.php';
?>

<body class="bg-gray-900 text-white">

    <header class="bg-gray-800 h-24 mb-10 flex items-center">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="home.php">
                <img src="../img/logo.png" alt="Streamhub Logo" class="w-32 h-32">
            </a>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6 text-lg font-semibold">
                <a href="#film-grid" class="hover:text-gray-400">Home</a>
                <a href="favorites.php" class="hover:text-gray-400">Favorite</a>
                <a href="#film-grid2" class="hover:text-gray-400">Movies</a>
                <a href="#film-grid1" class="hover:text-gray-400">Upcoming</a>
                <a href="#my-list" class="hover:text-gray-400">My List</a>
                <a href="filter.php" class="hover:text-gray-400">Filter</a>

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

    <body>
        <div id="my-list" class="container px-4 mx-auto py-8">
            <h1 class="text-4xl font-semibold mb-8">My Playlists</h1>
            <button onclick="openCreatePlaylistModal()" class="bg-indigo-500 text-white py-2 px-4 rounded mb-4">
                Create Playlist
            </button>
            <div id="playlists" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            </div>
        </div>
        <div id="createPlaylistModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl mb-4">Create Playlist</h2>
        <input id="playlistName" type="text" class="w-full px-4 py-2 rounded bg-gray-700 text-white mb-4" placeholder="Playlist Name">
        <button onclick="createPlaylist()" class="bg-indigo-500 text-white py-2 px-4 rounded">Create</button>
        <button onclick="closeCreatePlaylistModal()" class="bg-red-500 text-white py-2 px-4 rounded ml-2">Cancel</button>
    </div>
</div>

    </body>
