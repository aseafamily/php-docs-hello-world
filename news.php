<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<style>
body {
    background-color: black;
    color: white;
    font-family: Arial, sans-serif;
}

h4 {
    font-size: 16px;
    margin-top: 0;
    margin-bottom: 10px;
}

.card {
    background-color: #222;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
}

.card p {
    font-size: 14px;
    color: #ccc;
    margin: 5px 0;
}

.card img {
    width: 100%;
    border-radius: 5px;
    margin-bottom: 10px;
}

a {
    text-decoration: none;
    color: inherit;
}
</style>
</head>
<body>
<?php

session_start();

// Function to filter items based on an array of deleted titles
function filterItems($items, $deletedTitles) {
    $filteredItems = [];
    foreach ($items as $item) {
        $title = $item->getElementsByTagName('title')->item(0)->textContent;
        // Check if the title exists in the deleted titles array
        if (!in_array($title, $deletedTitles)) {
            // Add the item to filtered items
            $filteredItems[] = $item;
        }
    }
    return $filteredItems;
}

// URL of the New York Times homepage RSS feed
$rss_feed_url = 'https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml';

// Get the delete_title parameter from the query string
$deleteTitle = $_GET['delete_title'] ?? '';

// Retrieve deleted titles from session or initialize as empty array
$deletedTitles = $_SESSION['deleted_titles'] ?? [];

// Check if delete_title is provided
if (!empty($deleteTitle)) {
    $deleteTitle = urldecode($deleteTitle);
    // Add the delete_title to deleted titles array
    $deletedTitles[] = $deleteTitle;
    // Remove duplicate titles
    $deletedTitles = array_unique($deletedTitles);
    // Update deleted titles in session
    $_SESSION['deleted_titles'] = $deletedTitles;

    // print_r($_SESSION['deleted_titles']);
}

// Fetch RSS feed and parse it with DOMDocument
$rss_content = file_get_contents($rss_feed_url);
$rss_xml = new DOMDocument();
@$rss_xml->loadXML($rss_content);

// Get the items
$items = $rss_xml->getElementsByTagName('item');

// Shuffle the items randomly
$items_array = iterator_to_array($items);
$filteredItems = filterItems($items_array, $deletedTitles);
shuffle($filteredItems);

// Output each item
foreach ($filteredItems as $item) {
    $title = $item->getElementsByTagName('title')->item(0)->textContent;
    $link = $item->getElementsByTagName('link')->item(0)->textContent;
    $description = $item->getElementsByTagName('description')->item(0)->textContent;
    $pubDate = date('F j, Y, g:i a', strtotime($item->getElementsByTagName('pubDate')->item(0)->textContent));
    
    // Attempt to extract the image URL from the media:content tag
    $media_content = $item->getElementsByTagName('content');
    $image_url = '';
    foreach ($media_content as $media) {
        if ($media->getAttribute('medium') == 'image') {
            $image_url = $media->getAttribute('url');
            break;
        }
    }
    
    // Output item as a card
    echo '<div class="card">';
    echo '<h4>' . $title . '</h4>';
    if ($image_url) {
        echo '<img src="' . $image_url . '" alt="Image">';
    }
    echo '<p><strong>' . $description . ' <a href=' . $link. '></strong>link ...</a>';
    echo ' <a href=?delete_title=' . urlencode($title). '>Delete ...</a></p>';
    echo '<p><strong>Published Date:</strong> <span style="font-size: 12px;">' . $pubDate . '</span></p>';
    echo '</div>';
}
?>
<script>
// Auto refresh the page every 5 minutes
setTimeout(function() {
    window.location.href = window.location.origin + window.location.pathname;
}, 5 * 60 * 1000); // 5 minutes in milliseconds
</script>
</body>
</html>
