<?php

// Function to fetch the JSON response from the URL
function fetchJsonResponse($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function fetchJsonResponseFromFile($filePath) {
    // Read the contents of the file
    $jsonContents = file_get_contents($filePath);
    return $jsonContents;
}

// Fetch the JSON response from the URL
// $jsonResponse = fetchJsonResponse('https://randomwordgenerator.com/json/inspirational-quote_ws.json');
$jsonResponse = fetchJsonResponseFromFile("quotes.json");

// Decode the JSON response
$data = json_decode($jsonResponse, true);

// Check if the data node exists and contains an array of quotes
if (isset($data['data']) && is_array($data['data'])) {
    // Extract the inspirational_quote values into an array
    $filteredQuotes = array_filter($data['data'], function($quote) {
        return strlen($quote['inspirational_quote']) < 200;
    });


    if (!empty($filteredQuotes)) {
        $randomQuote = $filteredQuotes[array_rand($filteredQuotes)]['inspirational_quote'];

        // Check if the pattern " - <small><i>" is present in the quote
        if (strpos($randomQuote, ' - <small><i>') !== false) {
            // Split the quote into two lines at the " - <small><i>" pattern
            $lines = explode(' - <small><i>', $randomQuote);

            // Apply styles to each line
            $styledQuote = '<!DOCTYPE html><html><head><meta http-equiv="refresh" content="3600"></head>';
            $styledQuote .= '<body style="background-color: black; text-align: center;"><div style="background-color: black; color: #888; font-size: 90px; font-family: Montserrat, sans-serif; padding: 20px;">';
            $styledQuote .= '<div style="font-size: 90px;">' . $lines[0] . '</div>';
            $styledQuote .= '<div style="font-size: 45px; font-style: italic;"><br> - ' . $lines[1] . '</div>';
            $styledQuote .= '</div></body></html>';

            // Return the styled quote
            echo $styledQuote;
        } else {
            // Apply styles to the quote without the pattern
            $styledQuote = '<div style="background-color: black; color: #888; font-size: 90px; font-family: Montserrat, sans-serif; padding: 20px;">' . $randomQuote . '</div>';

            // Return the styled quote
            echo $styledQuote;
        }
    } else {
        echo 'No quotes found with length less than 100 characters.';
    }    
} else {
    echo 'Failed to fetch quote.';
}

?>
