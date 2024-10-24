<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video and Audio Background</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100%;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
        
        audio {
            display: none;
        }
    </style>
</head>
<body>
    <video id="introVideo" autoplay muted>
        <source src="video1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <audio id="backgroundAudio" autoplay>
        <source src="audio.mp3" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>
    
    <script>
        const video = document.getElementById('introVideo');
        const audio = document.getElementById('backgroundAudio');

        // Set video playback speed
        video.playbackRate = 0.8;

        // Sync audio with the video
        video.addEventListener('play', function() {
            audio.play();
        });

        video.addEventListener('pause', function() {
            audio.pause();
        });

        video.addEventListener('ended', function() {
            window.location.href = "../main page/home.php";
        });
    </script>
</body>
</html>
