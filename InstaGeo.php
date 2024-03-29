<?php
if (!empty($_GET['location'])) {
    /**
     * url to access the google maps api
     */
    $maps_url = 'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['location']);
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];
    /**
     * Instagram api request. build the url using the
     * coordinate values returned by the google maps api
     */
    $url = 'https://' .
        'api.instagram.com/v1/media/search' .
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&client_id= 44b8118dac7f4599a27c1a7c1accdcd2'; //my client API create yours under developer tools
    $json = file_get_contents($url);
    $array = json_decode($json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>InstaGeo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<form action="" method="get">
    <input type="text" name="location"/>
    <button type="submit">Submit</button>
</form>
<br/>
<div id="results" data-url="<?php if (!empty($url)) echo $url ?>">
    <?php
    if (!empty($array)) {
        foreach ($array['data'] as $key => $item) {
            echo '<img id="' . $item['id'] . '" src="' . $item['images']['low_resolution']['url'] . '" alt=""/><br/>';
        }
    }
    ?>
</div>
</body>
</html>