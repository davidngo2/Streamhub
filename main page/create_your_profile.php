<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-content.active {
            display: block;
        }

        .dropdown-content {
            width: 64;
            left: -10px;
        }

        .dropdown-content ul li img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>
    <?php
    include_once('../sign_in_up/checkLogin.php');
    checkLogin();
    ?>
</head>

<body class="bg-black text-white h-screen flex items-center justify-center">
    <div class="max-w-xl w-full">
        <h1 class="text-4xl font-bold mb-4">Add Profile</h1>
        <p class="text-gray-400 mb-6">Add a profile for another person watching Netflix.</p>

        <!-- Form Section -->
        <div class="flex items-center relative">
            <!-- Profile Picture (clickable) -->
            <div id="profilePicture" class="bg-blue-500 w-20 h-20 rounded-full flex items-center justify-center mr-6 cursor-pointer relative">
                <img src="" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover">
            </div>

            <!-- Dropdown for selecting/adding profiles -->
            <div id="profileDropdown" class="dropdown-content absolute top-24 bg-gray-800 text-white rounded p-4 shadow-lg w-64 z-10">
                <p class="mb-2 text-gray-400">Choose Profile</p>
                <ul>
                    <li class="cursor-pointer hover:bg-gray-700 p-2 rounded flex items-center">
                        <img src="profile1.jpg" alt="Profile 1">Profile 1
                    </li>
                    <li class="cursor-pointer hover:bg-gray-700 p-2 rounded flex items-center">
                        <img src="profile2.jpg" alt="Profile 2">Profile 2
                    </li>
                    <li class="cursor-pointer hover:bg-gray-700 p-2 rounded flex items-center">
                        <img src="add_profile.jpg" alt="Add New Profile">Add New Profile
                    </li>
                </ul>
            </div>

            <form action="" method="post" class="flex-grow">
                <div class="flex items-center mb-4">
                    <input type="text" placeholder="Kids" class="bg-gray-700 text-white py-2 px-4 rounded w-full focus:outline-none focus:ring-2 focus:ring-red-600">
                    <div class="flex items-center ml-4">
                        <input type="checkbox" id="kid" class="form-checkbox text-red-600 w-5 h-5">
                        <label for="kid" class="ml-2 text-gray-400">Kid?</label>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-red-600 py-2 px-6 rounded text-white hover:bg-red-700 focus:ring-2 focus:ring-red-600">
                        Continue
                    </button>
                    <button type="button" class="bg-gray-600 py-2 px-6 rounded text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for dropdown toggle -->
    <script>
        const profilePicture = document.getElementById('profilePicture');
        const profileDropdown = document.getElementById('profileDropdown');

        profilePicture.addEventListener('click', function() {
            profileDropdown.classList.toggle('active');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            if (!profilePicture.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });
    </script>
</body>

</html>
