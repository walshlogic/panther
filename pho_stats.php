<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Image Gallery</title>
    <style>
    .gallery img {
        width: 100px;
        /* Or your desired width */
        margin: 5px;
        border: 2px solid #ccc;
        transition: 0.3s;
    }

    .gallery img:hover {
        border-color: #777;
    }
    </style>
</head>

<body>
    <div id="imageGallery"
        class="gallery"></div>
    <script>
    function fetchImages() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'list_images.php?action=list_images', true); // Ensure the URL is correct
        xhr.responseType = 'json';
        xhr.onload = function() {
            if (xhr.status === 200) {
                var images = xhr.response;
                console.log(images); // Check the received images
                var gallery = document.getElementById('imageGallery');
                gallery.innerHTML = ''; // Clear the gallery
                images.forEach(function(imageName) {
                    var img = document.createElement('img');
                    img.src = '\\putnam-fl\\dfsroot\\groupdirs\\pa\\pa_photos\\photos\\082412' +
                    imageName; // Use the actual path
                    img.alt = imageName;
                    gallery.appendChild(img);
                });
            } else {
                console.error('Failed to load images');
            }
        };
        xhr.onerror = function() {
            console.error('An error occurred during the request');
        };
        xhr.send();
    }
    // Call fetchImages on page load
    window.onload = fetchImages;
    <?php
        // Inline PHP for the purpose of this example
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list_images') {
            $directory = "\\putnam-fl\\dfsroot\\groupdirs\\pa\\pa_photos\\photos\\082412"; // Use forward slashes or double backslashes in Windows paths
            $images = glob($directory . "*.jpg");
            $imageList = array();

            foreach ($images as $image) {
                $imageList[] = basename($image); // Store only the filename, not the path
            }

            header('Content-Type: application/json');
            echo json_encode($imageList);
            exit; // Prevent further PHP execution after JSON output
        }
        ?> < /body> < /html > < /html>