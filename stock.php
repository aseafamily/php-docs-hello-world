<?php

// Function to fetch stock price from Alpha Vantage API
function getStockPrice($symbol) {
    // Replace 'YOUR_API_KEY' with your actual Alpha Vantage API key
    $apiKey = 'U78LYQLIUZIWEE0D';
    $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=$symbol&apikey=$apiKey";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if the API response contains the stock price data
    if(isset($data['Global Quote']['05. price'])) {
        return $data['Global Quote']['05. price'];
    } else {
        return 'N/A';
    }
}

// List of stocks to get real-time prices for
$stocks = ['AAPL', 'GOOGL', 'MSFT', 'AMZN'];

echo '<h1>Real-time Stock Prices</h1>';
echo '<table border="1">';
echo '<tr><th>Symbol</th><th>Price</th></tr>';

// Iterate through each stock symbol and fetch its price
foreach($stocks as $stock) {
    $price = getStockPrice($stock);
    echo "<tr><td>$stock</td><td>$price</td></tr>";
}

echo '</table>';

?>
