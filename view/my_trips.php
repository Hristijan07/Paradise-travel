<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/my_trips.css" ?>">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <style>
        #main{background-image: url("<?= ASSETS_URL . "images/background.jpg" ?>");background-size: cover;}
        .center {display: block;margin-left: auto;margin-right: auto;width: 40%;height: 2.5rem;font-size: 18px;}
        #search-field{transition: 0.5s;outline: none;border: none;}
        #search-field:hover{width: 80%;border-radius: 10px;}
    </style>

</head>
<body>

    <header >
            <h1 id="title">Paradise travel</h1>
            <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="Logo">
    </header>

    <nav>
        <ul>
        <li><a href="<?= BASE_URL . "home" ?>">Home</a></li>
        <li> <a class="active">My Trips</a></li>
        <li style="border:none"><input class="center" id="search-field" type="text" name="query" autocomplete="off" placeholder=" Search..." style="float:left; text-align:left; margin-left:5px;"/></li>
        <?php include("view/log_menu.php");?>
        </ul>
    </nav>

    <div id="main">
        <div id="trips" class="col-6 col-s-8">
            <?php foreach ($trips as $trip): ?>
                <div class="trip">
                    <img src="<?= ASSETS_URL . "images" . $trip["image"] ?>" alt="<?= $trip["name"] ?>" class="trip_img left">
                    <div class="trip_txt left">
                        <h1 class="" style="float:none"><?= $trip["name"] ?></h1>
                        <p class="" style="float:none"><?= $trip["date_from"] ?> - <?= $trip["date_to"] ?></p>
                        <p class="" style="float:none">Price : <?= $trip["price"] ?> &#8364</p>
                    </div>
                    <div class="trip_btns" style="float:right">
                        <form id="card_form" action="<?= BASE_URL . "trip/info" ?>" method="get" >
                            <input type="hidden" name="id" value="<?= $trip["trip_id"] ?>" />
                            <button id="info" class="btn" style="float:none"><i class="fa fa-info-circle"></i></button>
                        </form>

                        <form action="<?= BASE_URL . "trip/map" ?>" method="get">
                            <input type="hidden" name="city_id" id="city_id" value="<?= $trip["city_id"] ?>">
                            <input type="hidden" name="trip_id" id="trip_id" value="<?= $trip["trip_id"] ?>">
                            <button id="location" class="btn"style="float:none"><i class='fas fa-map-marker-alt'></i></button>
                        </form>

                        <form action="<?= BASE_URL . "remove/booking" ?>" method="post">
                            <input type="hidden" name="booking" id="booking" value="<?= $trip["booking"] ?>">
                            <button id="delete" class="btn" style="float:none"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        function make_trip(data){
            $trip = $('<div class="trip"></div>');
            $image = $('<img src="<?= ASSETS_URL . "images"?>'+ data["image"] +'" alt="'+ data["name"] +'" class="trip_img left">');

            $text = $(' <div class="trip_txt left"></div>');
            $h1 = $('<h1 class="" style="float:none">' + data["name"] + '</h1>');
            $dates = $('<p class="" style="float:none">' + data["date_from"] + ' - ' + data["date_to"] + '</p>');
            $price = $(' <p class="" style="float:none">Price : ' + data["price"] + ' &#8364</p>');
            $text.append($h1);
            $text.append($dates);
            $text.append($price);

            $btn_div = $('<div class="trip_btns" style="float:right"></div>');
            $info_form = $('<form id="card_form" action="<?= BASE_URL . "trip/info" ?>" method="get" ></form>');
            $info_input = $(' <input type="hidden" name="id" value="' + data["trip_id"] + '" />');
            $info_btn = $('<button id="info" class="btn" style="float:none"></button>');
            $info_icon = $('<i class="fa fa-info-circle"></i>');
            $info_btn.append($info_icon);
            $info_form.append($info_input);
            $info_form.append($info_btn);
            $btn_div.append($info_form);

            $loc_form = $('<form action="<?= BASE_URL . "trip/map" ?>" method="get"></form>');
            $loc_input1 = $('<input type="hidden" name="city_id" id="city_id" value="' + data["city_id"] + '">');
            $loc_input2 = $('<input type="hidden" name="trip_id" id="trip_id" value="' + data["trip_id"] + '">');
            $loc_btn = $('<button id="location" class="btn"style="float:none"></button>');
            $loc_icon = $('<i class="fas fa-map-marker-alt"></i>');
            $loc_btn.append($loc_icon);
            $loc_form.append($loc_input1);
            $loc_form.append($loc_input2);
            $loc_form.append($loc_btn);
            $btn_div.append($loc_form);

            $del_form = $('<form action="<?= BASE_URL . "remove/booking" ?>" method="post"></form>');
            $del_input = $('<input type="hidden" name="booking" id="booking" value="' + data["booking"] + '">');
            $del_btn = $('<button id="delete" class="btn" style="float:none"></button>');
            $del_icon = $('<i class="fa fa-trash"></i>');
            $del_btn.append($del_icon);
            $del_form.append($del_input);
            $del_form.append($del_btn);
            $btn_div.append($del_form);

            $trip.append($image);
            $trip.append($text);
            $trip.append($btn_div);
            $("#trips").append($trip);
        }

        $("#search-field").keyup(function() {
            $("#trips").empty();
            $.get("<?= BASE_URL ."api/my_trips/search" ?>", { query :  $(this).val()} ,
            function(data) {
                    $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                        make_trip(value);
                    });
                });
            });
    });
    </script>
    
</body>
</html>