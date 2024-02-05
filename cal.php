
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Expose-Headers: *");


// 启用错误报告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fileToRequire = 'Lunar.php';

if (file_exists($fileToRequire)) {
    require $fileToRequire;
} else {
    echo "Error: The required file '$fileToRequire' does not exist or there was an issue including it.";
}
//echo "1";

use com\nlf\calendar\Lunar;
use com\nlf\calendar\Solar;

date_default_timezone_set('America/Los_Angeles');

$currentYear = date('Y');
$currentMonth = date('m');
$currentDate = date('d');

//echo $currentDate;
$mytime = Solar::fromYmd($currentYear,$currentMonth,$currentDate);
$lunar = Lunar::fromSolar($mytime);
//echo $lunar->toFullString()."\n";
//echo "<br/>";
echo $lunar->getYearInGanZhi()."(" . $lunar->getYearShengXiao() . ")\n";
echo "<br/>";
//echo $lunar->getYearShengXiao()."\n";
//echo "<br/>";
echo $lunar->getMonthInChinese()."月";
//echo "<br/>";
echo $lunar->getDayInChinese()."\n";
echo "<br/>";
$s = '';
foreach ($lunar->getFestivals() as $f) {
            $s .= $f . ' ';
        }
foreach ($lunar->getOtherFestivals() as $f) {
            $s .=  $f . ' ';
        }
if (strlen($s) > 0) {
	echo $s;
	echo "<br/>";
}

$jq = $lunar->getJieQi();
        if (strlen($jq) > 0) {
            echo $jq;
        }


// 星座
function getZodiacSign() {
    // Get the current date
    $currentDate = date('Y-m-d');

    // Convert the current date to DateTime object
    $dateTime = new DateTime($currentDate);

    // Get month and day
    $month = $dateTime->format('n');
    $day = $dateTime->format('j');

    // Determine the zodiac sign
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
        $zodiacSign = 'Aries';
        $zodiacSignChinese = '白羊座';
    } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
        $zodiacSign = 'Taurus';
        $zodiacSignChinese = '金牛座';
    } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
        $zodiacSign = 'Gemini';
        $zodiacSignChinese = '双子座';
    } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
        $zodiacSign = 'Cancer';
        $zodiacSignChinese = '巨蟹座';
    } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
        $zodiacSign = 'Leo';
        $zodiacSignChinese = '狮子座';
    } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
        $zodiacSign = 'Virgo';
        $zodiacSignChinese = '处女座';
    } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
        $zodiacSign = 'Libra';
        $zodiacSignChinese = '天秤座';
    } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
        $zodiacSign = 'Scorpio';
        $zodiacSignChinese = '天蝎座';
    } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
        $zodiacSign = 'Sagittarius';
        $zodiacSignChinese = '射手座';
    } elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
        $zodiacSign = 'Capricorn';
        $zodiacSignChinese = '摩羯座';
    } elseif (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
        $zodiacSign = 'Aquarius';
        $zodiacSignChinese = '水瓶座';
    } else {
        $zodiacSign = 'Pisces';
        $zodiacSignChinese = '双鱼座';
    }

    return array(
        'zodiacSign' => $zodiacSign,
        'zodiacSignChinese' => $zodiacSignChinese
    );
}

// Call the function to get the current zodiac sign
$zodiacInfo = getZodiacSign();

// Output the results
echo '<br/>';
echo '' . $zodiacInfo['zodiacSignChinese'] . PHP_EOL;
echo '<br/>';
echo ' ' . $zodiacInfo['zodiacSign'] . PHP_EOL;


?>
