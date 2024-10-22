<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhub User Account</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<?php
include_once '../database/conn.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$query = $conn->query("SELECT * FROM users WHERE user_id = " . $user_id);
while ($data = $query->fetch()) {
    $name = $data['gebruikernaam'];
    $email = $data['email'];
    $subscribsie = $data['subscribsie'];
    $start_date = $data['start_date'];
    $eind_date = $data['eind_date'];
    $email_changed = $data['email_changed'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Change Password
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Verify old password
        $query = $conn->prepare("SELECT wachtwoord FROM users WHERE user_id = :user_id");
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();

        if (password_verify($oldPassword, $result['wachtwoord'])) {
            if ($newPassword == $confirmPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateQuery = $conn->prepare("UPDATE users SET wachtwoord = :password WHERE user_id = :user_id");
                $updateQuery->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $updateQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                if ($updateQuery->execute()) {
                    echo '<script>alert("Password changed successfully!");</script>';
                } else {
                    echo '<script>alert("Failed to change password.");</script>';
                }
            } else {
                echo '<script>alert("Passwords do not match.");</script>';
            }
        } else {
            echo '<script>alert("Old password is incorrect.");</script>';
        }
    }

    // Handle Change Username
    if (isset($_POST['new_username'])) {
        $newUsername = $_POST['new_username'];
        if (!empty($newUsername) && $newUsername != $name) {
            $updateUsernameQuery = $conn->prepare("UPDATE users SET gebruikernaam = :username WHERE user_id = :user_id");
            $updateUsernameQuery->bindParam(':username', $newUsername, PDO::PARAM_STR);
            $updateUsernameQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if ($updateUsernameQuery->execute()) {
                echo '<script>alert("Username updated successfully!");</script>';
            } else {
                echo '<script>alert("Failed to update username.");</script>';
            }
        }
    }

    // Handle Change Email (One-Time Only)
    if (isset($_POST['new_email']) && $email_changed == 0) {
        $newEmail = $_POST['new_email'];
        if (!empty($newEmail) && filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $updateEmailQuery = $conn->prepare("UPDATE users SET email = :email, email_changed = 1 WHERE user_id = :user_id");
            $updateEmailQuery->bindParam(':email', $newEmail, PDO::PARAM_STR);
            $updateEmailQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if ($updateEmailQuery->execute()) {
                echo '<script>alert("Email updated successfully!");</script>';
            } else {
                echo '<script>alert("Failed to update email.");</script>';
            }
        } else {
            echo '<script>alert("Invalid email address.");</script>';
        }
    } elseif ($email_changed == 1) {
        echo '<script>alert("Email can only be changed once.");</script>';
    }
}
?>

<body class="bg-gray-900 text-white font-sans">
    <div class="logo flex justify-between items-center border-b border-yellow-600 mb-6">
        <a href="../sign_in_up/sign_in.php">
            <img src="../img/logo.png" alt="Netflix Logo" class="w-32">
        </a>
        <a href="../sign_in_up/sign_in.php" class="ml-auto text-white font-semibold text-lg px-6">Sign Out</a>
    </div>

    <div class="flex justify-center items-center mt-8">
        <!-- Left Side: Form -->
        <div class="w-full max-w-lg">
            <div class="flex">
                <img src="../img/user.png" alt="" class="w-8 h-8 mr-2">
                <h2 class="text-3xl font-bold mb-8">Edit Profile</h2>
            </div>
            <div class="bg-gray-800 shadow-lg p-8">

                <!-- Profile Information Form -->
                <form action="" method="post" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Email Address</label>
                        <input type="email" placeholder="<?php echo $email; ?>" class="w-full p-3 bg-gray-700 text-white rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">You will be able to change the email ONCE ONLY.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">User Name</label>
                        <input type="text" placeholder="<?php echo $name; ?>" class="w-full p-3 bg-gray-700 text-white rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400">Joined</label>
                        <input type="text" placeholder="<?php echo $start_date; ?>" class="w-full p-3 bg-gray-900 text-white rounded-lg text-gray-500" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Eind subscribtion date</label>
                        <input type="text" placeholder="<?php echo $eind_date; ?>" class="w-full p-3 bg-gray-900 text-white rounded-lg text-gray-500" disabled>
                    </div>

                    <!-- Change Password Section -->
                    <div>
                        <input type="checkbox" id="changePassword" class="mr-2">
                        <label for="changePassword" class="text-gray-400 text-sm">Change Password</label>
                    </div>

                    <div class="mt-4 space-y-4 hidden" id="passwordFields">
                        <input type="password" placeholder="Old Password" name="old password" class="w-full p-3 bg-gray-700 text-white rounded-lg">
                        <input type="password" placeholder="New Password" name="new_password" class="w-full p-3 bg-gray-700 text-white rounded-lg">
                        <input type="password" placeholder="Confirm New Password" name="confirm_password" class="w-full p-3 bg-gray-700 text-white rounded-lg">
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="w-full bg-yellow-500 text-black p-3 rounded-lg mt-6 font-semibold hover:bg-yellow-600">Save</button>
                </form>
            </div>
        </div>
        <div class="bg-gray-700 p-8 h-96 flex flex-col justify-center">
            <div class="flex justify-center mb-4">
                <img src="../img/profile.jpg" alt="Your Profile" class="rounded-full w-32 border-4 border-gray-700 mb-4">
            </div>
            <div class="text-center">
                <p class="text-gray-300 text-lg font-semibold"><?php echo $name; ?></p>
                <p class="text-gray-400 text-sm">Member since: <?php echo $start_date; ?></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('changePassword').addEventListener('change', function() {
            const passwordFields = document.getElementById('passwordFields');
            passwordFields.classList.toggle('hidden');
        });
    </script>
</body>

</html>
