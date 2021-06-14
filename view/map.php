<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/map.css" ?>">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">

    <style>
        #map  { height: 80%; margin: 20px;}
    </style>
</head>
<body>
    <header>
        <a id="back" class="back">&#10094;</a>
        <h1 id="title">Paradise travel</h1>
        <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="">
    </header>

    <nav>
        <ul>
        <li><a href="<?= BASE_URL . "home" ?>">Home</a></li>
        
        <?php if($booked == 0): ?>
            <li> <a id="book_link" >Book</a></li>
        <?php elseif ($booked == 1): ?>
            <li> <a href="<?= BASE_URL . "my/trips" ?>">My Trips</a></li>
        <?php endif; ?>
            
        <?php include("view/log_menu.php");  ?>
        </ul>

    </nav>

    <div id="map"> </div>

    <div class="main_part row">
        <div class="btn_container col-12" style="padding:0">
            <?php if($booked == 0): ?>
                <button class="btn" id="book_btn">Book Now</button>
            <?php elseif ($booked == 1): ?>
                <button class="btn">Booked &#10003</button>
            <?php endif; ?>
        </div>
    </div>

    <footer class="col-12">
        <h2> University of Ljubjana - ST </h2>
    </footer>  

    <form id="back_form" action="<?= BASE_URL . "trip/info" ?>" method="get" >
        <input type="hidden" name="id" value="<?= $trip ?>" />
    </form>

    <form id="book_form" action="<?= BASE_URL . "trip/book" ?>" method="post">
        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION["user"]["user_id"] ?>">
        <input type="hidden" name="trip_id" id="trip_id" value="<?= $trip ?>">
    </form>

    <script>
        var lon = "<?= $lon ?>"
        var lat = "<?= $lat ?>";
        var city = "<?= $city ?>";
        var image = "<?= ASSETS_URL . "images" . $image ?>";
        var price = "<?= $price ?>";

        var map = L.map('map').setView([lon, lat], 12);

        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=uR8J1hmV7MI32xcpR56R',
        { attribution : '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'}).addTo(map);
        var marker = L.marker([lon, lat]).addTo(map);

        var customOptions =
        {
        'minWidth': '200',
        }

        marker.bindPopup('<img src="'+ image + '" /><h1>' + city + '</h1> <br> Price: ' + price + ' &#8364', customOptions).openPopup();
        
        document.getElementById("back").onclick = function(){
            document.getElementById("back_form").submit();
        };

        <?php if($booked == 0): ?>
            var book = document.getElementById("book_form");
            document.getElementById("book_btn").onclick = function(){
                book.submit();
            };
            document.getElementById("book_link").onclick = function(){
                book.submit();
            };
        <?php elseif ($booked == 1): ?>
           
        <?php endif; ?>

       
        
    </script>

</body>
</html>