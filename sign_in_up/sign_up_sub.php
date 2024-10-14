<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="signup.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="bg-gray-900 text-gray-200 font-sans">
    <div class="logo flex justify-between items-center border-b border-yellow-600 mb-6">
        <a href="sign_in.php">
            <img src="../img/logo.png" alt="Netflix Logo" class="w-32">
        </a>
        <a href="sign_in.php" class="ml-auto text-white font-semibold text-lg px-6">Sign In</a>
    </div>
    <div class="max-w-4xl mx-auto text-white">
        <p class="text-xs">STEP <strong>1</strong> OF <strong>3</strong></p>
        <p class="text-3xl font-semibold mb-4">Choose the plan that's right for you.</p>
        <p class="mb-4 text-xl"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span> Watch all you want. Advert-free.</p>
        <p class="mb-4 text-xl"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span> Recommendations just for you.</p>
        <p class="mb-4 text-xl"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span> Change or cancel your plan at any time.</p>
        <div class="text-center mr-10 flex justify-end items-center">
            <div>
                <button class="bg-yellow-500 text-gray-900 px-8 py-10 text-xl mb-4 mr-4 rounded" onclick="highlightRow(1)">Basic</button>
                <button class="bg-yellow-500 text-gray-900 px-4 py-10 text-xl mb-4 mr-4 rounded" onclick="highlightRow(2)">Standard</button>
                <button class="bg-yellow-500 text-gray-900 px-4 py-10 text-xl mb-4 rounded" onclick="highlightRow(3)">Premium</button>
            </div>
        </div>
        <div>
            <table class="text-xl mb-4 w-full">
                <tr class="border-b border-yellow-600" id="row1">
                    <th class="w-[54%] text-left font-normal px-4 py-3">Monthly price</th>
                    <td class="price1 text-center">€7.99</td>
                    <td class="price2 text-center">€11.99</td>
                    <td class="price3 text-center">€15.99</td>
                </tr>
                <tr class="border-b border-yellow-600" id="row2">
                    <th class="w-[54%] text-left font-normal px-4 py-3">Video quality</th>
                    <td class="quality1 text-center">Good</td>
                    <td class="quality2 text-center">Better</td>
                    <td class="quality3 text-center">Best</td>
                </tr>
                <tr class="border-b border-yellow-600" id="row3">
                    <th class="w-[54%] text-left font-normal px-4 py-3">Resolution</th>
                    <td class="resolution1 text-center">720p</td>
                    <td class="resolution2 text-center">1080p</td>
                    <td class="resolution3 text-center">4K+HDR</td>
                </tr>
                <tr id="row4">
                    <th class="w-[54%] text-left font-normal px-4 py-3">Watch on your TV, computer, mobile phone and tablet</th>
                    <td class="check1 text-center"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span></td>
                    <td class="check2 text-center"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span></td>
                    <td class="check3 text-center"><span class="text-yellow-500" style="font-size: 40px;">&#10003;</span></td>
                </tr>
            </table>
            <p class="mb-4">HD (720p), Full HD (1080p), Ultra HD (4K) and HDR availability subject to your internet service and device capabilities. Not all content is available in all resolutions. See our Terms of Use for more details.</p>
            <p class="mb-10">Only people who live with you may use your account. Watch on 4 different devices at the same time with Premium, 2 with Standard and 1 with Basic.</p>
            <div class="max-w-xs mx-auto">
                <button onclick="redirectToSignUp()" class="bg-yellow-500 text-gray-900 px-48 py-3 mt-4 rounded text-2xl">Next</button>
            </div>
        </div>
    </div>
    <script src="signup_sript.js"></script>
</body>

</html>
