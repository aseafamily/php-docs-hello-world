<?php

// Function to fetch stock price from Yahoo Finance API
function getStockPrice($symbol) {
    $url = "https://query1.finance.yahoo.com/v8/finance/chart/$symbol";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if the API response contains the stock price data
    if(isset($data['chart']['result'][0]['meta']['regularMarketPrice'])) {
        return $data['chart']['result'][0]['meta']['regularMarketPrice'];
    } else {
        return 'N/A';
    }
}

// Function to fetch previous close price from Yahoo Finance API
function getPreviousClose($symbol) {
    $url = "https://query1.finance.yahoo.com/v8/finance/chart/$symbol";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if the API response contains the previous close price data
    if(isset($data['chart']['result'][0]['meta']['previousClose'])) {
        return $data['chart']['result'][0]['meta']['previousClose'];
    } else {
        return 'N/A';
    }
}

// Function to calculate price movement in percentage
function calculateMovementPercentage($price, $previousClose) {
    if ($price != 'N/A' && $previousClose != 'N/A') {
        $movement = (($price - $previousClose) / $previousClose) * 100;
        return number_format($movement, 2);
    } else {
        return 'N/A';
    }
}

// List of stocks to get real-time prices and movements for
$stocks = ['SPY', 'MSFT', 'TSLA', 'GOOG', 'NGD', 'NVDA', 'AAPL', 'META', 'GOLD', 'RDFN', '000001.SS', 'CNH=X'];

echo '<style>
    body {
        background-color: #000;
        color: #fff;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #000;
        color: #fff;
    }
    .movement {
        font-weight: bold;
    }
    .up {
        color: #4CAF50; /* Green */
    }
    .down {
        color: #f44336; /* Red */
    }
</style>';

echo '<table id="stockTable">';
echo '<tr><th>Symbol</th><th>Price</th><th>Movement (%)</th></tr>';

// Iterate through each stock symbol and fetch its price and movement
foreach($stocks as $stock) {
    $price = getStockPrice($stock);
    $previousClose = getPreviousClose($stock);
    $movementPercentage = calculateMovementPercentage($price, $previousClose);
    $movementDisplay = ($movementPercentage >= 0) ? '+' . $movementPercentage : $movementPercentage;
    echo "<tr><td>$stock</td><td>$price</td><td class='".(($movementPercentage >= 0) ? 'up' : 'down')." movement'>$movementDisplay%</td></tr>";
}

echo '</table>';

?>

<script>
// Function to refresh the page every 5 minutes
setTimeout(function() {
    location.reload();
}, 5 * 60 * 1000); // 5 minutes in milliseconds
</script>
