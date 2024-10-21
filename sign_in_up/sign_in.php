<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
</head>
<?php
    session_start();
    include_once('../database/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database query
    $sql = "SELECT * FROM user WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['wachtwoord'])) {
        $user_id = $row['id'];
        $_SESSION['user_id'] = $user_id;
        header('Location: welcome.php');
        exit;
    } else {
        echo "Inloggen mislukt.";
    }
}
?>

<body class="bg-gray-900">
    <div class="flex min-h-screen">
        <div class="hidden md:flex md:w-4/6 bg-cover bg-no-repeat bg-center rounded-l-lg" style="background-image: url('../img/film.png');">
        </div>
        <div class="flex flex-col justify-center md:w-1/3 p-8 bg-gray-900 rounded-r-lg">
            <div class="flex justify-center">
                <img class="w-48" src="../img/logo.png"></img>
            </div>
            <p class="text-center text-gray-400">Don't have an account? <a href="sign_up_info.php" class="text-yellow-500 hover:underline">Sign Up</a></p>
            <div class="flex justify-center items-center">
                <hr class="w-1/4 border-gray-600">
                <span class="px-4 text-gray-400 text-center mt-4 mb-4">OR ELSE</span>
                <hr class="w-1/4 border-gray-600">
            </div>
            <h2 class="text-2xl text-white mb-4 text-center">Welcome Back</h2>
            <p class="text-center text-gray-400 mb-6">Enter your Details</p>

            <form action="" method="post" class="space-y-6">
                <input type="email" placeholder="Enter your Email" name="email" class="w-full px-4 py-3 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <input type="password" placeholder="Enter your Password" name="password" class="w-full px-4 py-3 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <button type="submit" class="w-full px-4 py-3 rounded bg-yellow-500 text-white text-base hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    Continue
                </button>

                <div class="flex justify-center items-center my-4">
                    <hr class="w-1/4 border-gray-600">
                    <span class="px-4 text-gray-400">OR</span>
                    <hr class="w-1/4 border-gray-600">
                </div>

                <div class="space-y-3">
                    <button type="button" class="w-full px-4 py-3 rounded bg-white text-gray-800 flex items-center justify-center">
                        <img src="../img/google.jpg" alt="Google" class="w-5 h-5 mr-3"> Continue With Google
                    </button>
                    <button type="button" class="w-full px-4 py-3 rounded bg-white text-gray-800 flex items-center justify-center">
                        <img src="../img/facebook.jpg" alt="Facebook" class="w-5 h-5 mr-3"> Continue With Facebook
                    </button>
                    <button type="button" class="w-full px-4 py-3 rounded bg-white text-gray-800 flex items-center justify-center">
                        <img src="../img/apple.png" alt="Apple" class="w-5 h-5 mr-3"> Continue With Apple
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
