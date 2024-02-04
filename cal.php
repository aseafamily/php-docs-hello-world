
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

$currentYear = date('Y');
$currentMonth = date('m');
$currentDate = date('d');


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


?>
