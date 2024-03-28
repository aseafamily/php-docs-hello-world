<?php

// NewsAPI API key
$apiKey = 'e7d047b73b0a468b8b8d11fb17b8dec8';

// Function to fetch top news headlines with images using cURL
function getTopNewsWithImages($apiKey) {
    $url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=$apiKey&pageSize=10";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

// Call the function to get top news headlines with images
$news = getTopNewsWithImages($apiKey);

// Check if the response contains news data
if(isset($news['articles'])) {
    // Randomly shuffle the news articles array
    shuffle($news['articles']);

    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<style>';
    echo 'body { background-color: #000; color: #fff; font-family: Arial, sans-serif; }';
    echo '.news-item { padding: 10px; margin-bottom: 10px; background-color: #333; border-radius: 10px; }';
    echo '.news-title { font-size: 18px; margin: 10px; }';
    echo '.news-image { max-width: 100%; height: auto; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';

    foreach($news['articles'] as $article) {
        echo '<div class="news-item">';
        echo '<h4 class="news-title">' . $article['title'] . '</h4>';
        if(isset($article['urlToImage'])) {
            echo '<img class="news-image" src="' . $article['urlToImage'] . '" alt="News Image">';
        }
        echo '</div>';
    }

    echo '</body>';
    echo '</html>';
} else {
    echo 'Failed to fetch news.';
}

?>
