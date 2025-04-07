<?php
// Include your database connection file
require_once '../database/conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = password_hash($_POST["wachtwoord"], PASSWORD_DEFAULT); // Hash the password for security
    $gebruikernaam = $_POST["gebruikernaam"];

    // Payment details
    $cardholderName = $_POST['cardholderName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $securityCode = $_POST['securityCode'];

    // Subscription details
    $subscription = isset($_GET['selectedSubscription']);
    $price = 0;
    $subscriptionType = "";

    switch ($subscription) {
        case 1:
            $subscriptionType = "Basic";
            $price = 9.99;
            break;
        case 2:
            $subscriptionType = "Standard";
            $price = 13.99;
            break;
        case 3:
            $subscriptionType = "Premium";
            $price = 17.99;
            break;
    }

    // Validate the payment form
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($cardholderName) && !empty($cardNumber) && !empty($expiryDate) && !empty($securityCode)) {
        // Email and payment details are valid
        try {
            // Set the current date and the date after today
            $startDate = date("Y-m-d");
            $endDate = date("Y-m-d", strtotime("+1 day"));

            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("INSERT INTO user (email, gebruikernaam, wachtwoord, start_date, eind_date, subscribsie) VALUES (:email, :gebruikernaam, :password, :startDate, :endDate, :subscriptionType)");

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':gebruikernaam', $gebruikernaam);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
            $stmt->bindParam(':subscriptionType', $subscriptionType);
            $stmt->execute();

            // Redirect to next step
            header(header: "Location: next_step.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Display error if the payment information is missing or incorrect
        echo "Please fill out all payment details correctly.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-lg w-full max-w-6xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="space-y-6">
          <h2 class="text-2xl font-semibold">Payment</h2>
          <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between">
            <div>
              <label class="inline-flex items-center">
                <input type="radio" name="payment" class="form-radio text-blue-600" id="visaOption">
                <span class="ml-2 text-white">Visa ending in 7658</span>
              </label>
            </div>
            <img src="../img/visa.png" class="w-16 h-auto opacity-80" alt="Visa">
          </div>
          <div id="visaForm" class="bg-gray-600 p-4 rounded-lg mt-4 hidden">
            <form action="" method="POST">
              <div>
                <label class="block text-white" for="cardholderName">Cardholder name</label>
                <input type="text" id="cardholderName" name="cardholderName" class="w-full p-2 rounded-lg mt-2" placeholder="Enter your name as it's written on the card">
              </div>

              <div class="mt-4">
                <label class="block text-white" for="cardNumber">Card number</label>
                <input type="text" id="cardNumber" name="cardNumber" class="w-full p-2 rounded-lg mt-2" placeholder="1234 1234 1234 1234">
              </div>

              <div class="mt-4 flex space-x-4">
                <div class="w-1/3">
                  <label class="block text-white" for="expiryDate">Expiry date</label>
                  <input type="text" id="expiryDate" name="expiryDate" class="w-full p-2 rounded-lg mt-2" placeholder="MM / YY">
                </div>

                <div class="w-1/3">
                  <label class="block text-white" for="securityCode">Security code</label>
                  <input type="text" id="securityCode" name="securityCode" class="w-full p-2 rounded-lg mt-2" placeholder="CVC">
                </div>
              </div>

              <div class="mt-4">
                <label class="inline-flex items-center text-white">
                  <input type="checkbox" class="form-checkbox">
                  <span class="ml-2">Use this payment method for all subscriptions on my account</span>
                </label>
              </div>
            </form>
          </div>


          <!-- Mastercard Section -->
          <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between">
            <div>
              <label class="inline-flex items-center">
                <input type="radio" name="payment" class="form-radio text-blue-600" id="mastercardOption">
                <span class="ml-2 text-white">Mastercard ending in 8429</span>
              </label>
            </div>
            <img src="../img/master.png" class="w-16 h-auto opacity-80" alt="Mastercard">
          </div>

          <!-- Mastercard Payment form -->
          <div id="mastercardForm" class="bg-gray-600 p-4 rounded-lg mt-4 hidden">
            <form action="" method="POST">
              <div>
                <label class="block text-white" for="masterCardholderName">Cardholder name</label>
                <input type="text" id="masterCardholderName" name="masterCardholderName" class="w-full p-2 rounded-lg mt-2" placeholder="Enter your name as it's written on the card">
              </div>

              <div class="mt-4">
                <label class="block text-white" for="masterCardNumber">Card number</label>
                <input type="text" id="masterCardNumber" name="masterCardNumber" class="w-full p-2 rounded-lg mt-2" placeholder="1234 1234 1234 1234">
              </div>

              <div class="mt-4 flex space-x-4">
                <div class="w-1/2">
                  <label class="block text-white" for="masterExpiryDate">Expiry date</label>
                  <input type="text" id="masterExpiryDate" name="masterExpiryDate" class="w-full p-2 rounded-lg mt-2" placeholder="MM / YY">
                </div>

                <div class="w-1/2">
                  <label class="block text-white" for="masterSecurityCode">Security code</label>
                  <input type="text" id="masterSecurityCode" name="masterSecurityCode" class="w-full p-2 rounded-lg mt-2" placeholder="CVC">
                </div>
              </div>

              <div class="mt-4">
                <label class="inline-flex items-center text-white">
                  <input type="checkbox" class="form-checkbox">
                  <span class="ml-2">Use this payment method for all subscriptions on my account</span>
                </label>
              </div>
            </form>
          </div>

          <!-- iDEAL Section -->
          <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between">
            <div>
              <label class="inline-flex items-center">
                <input type="radio" name="payment" class="form-radio text-blue-600" id="idealOption">
                <span class="ml-2 text-white">Pay with iDEAL</span>
              </label>
            </div>
            <img src="../img/ideal.png" class="w-16 h-auto opacity-80" alt="iDEAL">
          </div>

          <!-- iDEAL Payment form -->
          <div id="idealForm" class="bg-gray-600 p-4 rounded-lg mt-4 hidden">
            <form action="" method="POST">
              <div>
                <label class="block text-white" for="idealBank">Select your bank</label>
                <select id="idealBank" name="idealBank" class="w-full p-2 rounded-lg mt-2 text-gray-500">
                  <option value="">Select your bank</option>
                  <option value="ING">ING</option>
                  <option value="ABN AMRO">ABN AMRO</option>
                  <option value="Rabobank">Rabobank</option>
                  <option value="SNS Bank">SNS Bank</option>
                  <option value="ASN Bank">ASN Bank</option>
                  <option value="Bunq">Bunq</option>
                </select>
              </div>

              <div class="mt-4">
                <label class="inline-flex items-center text-white">
                  <input type="checkbox" class="form-checkbox">
                  <span class="ml-2">Use this payment method for all subscriptions on my account</span>
                </label>
              </div>
            </form>
          </div>


          <p class="text-center text-gray-400">or</p>
          <div>
            <h3 class="text-gray-500">Add a new payment method</h3>
            <div class="space-y-4 mt-4">
              <div class="flex space-x-4">
                <h3 class="font-semibold mr-6">Full name (as displayed on card)</h3>
                <h3 class="font-semibold">Card number</h3>
              </div>
              <div class="flex space-x-4">
                <input type="text" class="w-1/2 p-3 bg-gray-700 rounded-lg text-gray-400" placeholder="Jonh Doe"> <!-- Adjusted padding -->
                <input type="text" class="w-1/2 p-3 bg-gray-700 rounded-lg text-gray-400" placeholder="xxxx-xxxx-xxxx-xxxx">
              </div>
              <div class="flex space-x-4">
                <h3 class="font-semibold mr-36">Card expiration</h3>
                <h3 class="font-semibold">CVV</h3>
              </div>
              <div class="flex space-x-4">
                <input type="text" class="w-1/2 p-3 bg-gray-700 rounded-lg text-gray-400" placeholder="Card expiration">
                <input type="text" class="w-1/2 p-3 bg-gray-700 rounded-lg text-gray-400" placeholder="xxx">
              </div>
              <button class="w-full bg-blue-600 py-2 rounded-lg font-semibold">Pay now</button>
            </div>
          </div>
        </div>

        <!-- Total Section -->
        <div class="md:col-span-1 mt-14">
          <div class="bg-gray-700 p-8 rounded-lg space-y-6 mb-5">
            <div class="space-y-4">
              <div class="flex justify-between">
                <span>Original price</span>
                <span><?php echo $price ?></span>
              </div>
              <div class="flex justify-between text-green-500">
                <span>subscriptions</span>
                <span><? echo $subscriptionType ?></span>
              </div>
              <div class="flex justify-between">
                <span>Store Pickup</span>
                <span>$99</span>
              </div>
              <div class="flex justify-between">
                <span>Tax</span>
                <span>$799</span>
              </div>
              <hr class="border-gray-600">
              <div class="flex justify-between font-bold text-xl">
                <span>Total</span>
                <span>$7,191.00</span>
              </div>
            </div>
          </div>
          <div class="bg-gray-700 p-8 rounded-lg space-y-6">
            <div class="space-y-4">
              <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c0-1.105.895-2 2-2h8c1.105 0 2 .895 2 2v8c0 1.105-.895 2-2 2h-8c-1.105 0-2-.895-2-2V8zm4 4h4m-6 2h2"></path>
                </svg>
                <p class="text-gray-400">-10% Extra</p>
              </div>
              <p class="text-sm text-gray-500">You get 10% extra when purchasing this product, for orders of at least $100! <a href="#" class="text-blue-400">Save the promo code in your account →</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="signup_sript.js"></script>

</html>
