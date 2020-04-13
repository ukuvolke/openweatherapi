<?php
    date_default_timezone_set('Europe/Tallinn');
    $url = 'http://api.openweathermap.org/data/2.5/weather?q=Kuressaare,ee&appid=65b2ddba520baf9fa54f8c78b81c1da5&units=metric';
    $fileName = './cache.json';
    $cacheTime = 30;
    $filemtime=filemtime("./cache.json");
    $humantime=date('Y-m-d H:i:s', $filemtime);
    

    
    if ( file_exists($fileName) && (time() - filemtime($fileName) < $cacheTime) ) {
        $content = file_get_contents($fileName);
    } else {
        $content = file_get_contents($url);

        $file = fopen($fileName, 'w');
        fwrite($file, $content);
        fclose($file);
    }

    $json = json_decode($content);
    $päiketõus=date('H:i:s',$json->sys->sunrise);
    $päikeloojang=date('H:i:s',$json->sys->sunset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuressaare ilm</title>
</head>
<body>
<div>
    <h1>Hetke ilm Kuressaares</h1>
    <p>Temperatuur on <?php echo $json->main->temp;?> kraadi</p>
    <p>Tuul puhub tugevusega <?php echo $json->wind->speed;?> meetrit sekundis</p>
    <img src="http://openweathermap.org/img/wn/<?php echo $json->weather[0]->icon;?>@2x.png">
    <br>
    <p>Päikese tõus:<?php echo $päiketõus;?></p>
    <p>Päikese loojang:<?php echo $päikeloojang;?></p>
    <br>
    <p>Andmed uuendatud <?php echo $humantime;?></p>
    </div>
    
    



</body>
</html>

