<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/add_trip.css" ?>">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">

    <style>
        #p_city_name{margin-top: 5px;}
        #main{background-color: #ffd5e5;}
        ul { background-color: #ffffdd;}
        header {background-color: #a0ffe6;}
    </style>

</head>
<body>
    <?php
        if(empty($errors["img1"]) && !empty($data["img1"])){$img1 = $data["img1"];} else{$img1 = "/travel.png";}
        if(empty($errors["img2"]) && !empty($data["img2"])){$img2 = $data["img2"];} else{$img2 = "/travel.png";}
        if(empty($errors["img3"]) && !empty($data["img3"])){$img3 = $data["img3"];} else{$img3 = "/travel.png";}
        if(empty($errors["img4"]) && !empty($data["img4"])){$img4= $data["img4"];} else{$img4 = "/travel.png";}

        if(!empty($data["clr1"])){$clr1 = $data["clr1"];} else{$clr1 = "#1e2022";}
        if(!empty($data["clr2"])){$clr2 = $data["clr2"];} else{$clr2 = "#52616b";}
        if(!empty($data["clr3"])){$clr3 = $data["clr3"];} else{$clr3 = "#c9d6df";}
        if(!empty($data["clr4"])){$clr4= $data["clr4"];} else{$clr4 = "#f0f5f9";}
       
    ?>

    <header style="background-color: <?= $city["c_palette"][0] ?>; ">
        <h1 id="title">Paradise travel</h1>
        <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="Logo">
    </header>

    <nav style="background-color: <?= $city["c_palette"][1] ?>; ">
        <ul>
            <li><a href="<?= BASE_URL . "home" ?>">Home</a></li>
            <li id="clear"><a>Clear Form</a></li>
            <li id="demo"><a>Demo</a></li>
            <?php include("view/log_menu.php");  ?>
        </ul>
    </nav>

    <div id="main">
        <form action="<?= BASE_URL . "trip/add" ?>" method="post"> 
            <div class="row">
                <div class="item col-3 col-s-6">
                    <p class="input_part" id="p_city_name"><label for="city_name">City Name:</label>
                        <input type="text" name="city_name" id="city_name" value="<?= $data["city_name"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["city_name"] ?></p>
                </div>
            </div>


            <div class="row">
                <div class="item col-3 col-s-6">
                    <p class="input_part"  ><label for="img1">Image1:</label>
                        <input type="text" name="img1" id="img1" value="<?= $data["img1"] ?>"/>
                    </p>
                    <img id="image1" class="img_preview" src="<?= ASSETS_URL . "images" . $img1 ?>" alt="Img1">
                    <p id="img_error1" class="important"><?= $errors["img1"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part"><label for="img2">Image2:</label>
                        <input type="text" name="img2" id="img2" value="<?= $data["img2"] ?>"/>
                    </p>
                    <img id="image2" class="img_preview" src="<?= ASSETS_URL . "images" . $img2 ?>" alt="Logo">
                    <p id="img_error2" class="important"><?= $errors["img2"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="img3">Image3:</label>
                        <input type="text" name="img3" id="img3" value="<?= $data["img3"] ?>"/>
                    </p>
                    <img id="image3" class="img_preview" src="<?= ASSETS_URL . "images" . $img3 ?>" alt="Logo">
                    <p id="img_error3" class="important"><?= $errors["img3"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part"><label for="img4">Image4:</label>
                        <input type="text" name="img4" id="img4" value="<?= $data["img4"] ?>"/>
                    </p>
                    <img id="image4" class="img_preview" src="<?= ASSETS_URL . "images" . $img4 ?>" alt="Logo">
                    <p id="img_error4" class="important"><?= $errors["img4"] ?></p>
                </div>
            </div>

            <div class="row">
                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="lon">Longitude:</label>
                        <input type="text" name="lon" id="lon" value="<?= $data["lon"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["lon"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="lat">Latitude:</label>
                        <input type="text" name="lat" id="lat" value="<?= $data["lat"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["lat"] ?></p>
                </div>
            </div>

            <div class="row">
                <div class="item col-3 col-s-6">
                <p class="input_part" ><label for="clr1">Color1:</label>
                        <input type="text" name="clr1" id="clr1" value="<?= $data["clr1"] ?>" placeholder="Hexed value, ex: #FFFFFF"/>
                    </p>

                    <p id="clr1_error" class="important"><?= $errors["clr1"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                <p class="input_part" ><label for="clr2">Color2:</label>
                        <input type="text" name="clr2" id="clr2" value="<?= $data["clr2"] ?>" placeholder="Hexed value, ex: #FFFFFF"/>
                    </p>

                    <p id="clr2_error" class="important"><?= $errors["clr2"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                <p class="input_part" ><label for="clr3">Color3:</label>
                        <input type="text" name="clr3" id="clr3" value="<?= $data["clr3"] ?>" placeholder="Hexed value, ex: #FFFFFF"/>
                    </p>

                    <p id="clr3_error" class="important"><?= $errors["clr3"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                <p class="input_part" ><label for="clr4">Color4:</label>
                        <input type="text" name="clr4" id="clr4" value="<?= $data["clr4"] ?>" placeholder="Hexed value, ex: #FFFFFF"/>
                    </p>

                    <p id="clr4_error" class="important"><?= $errors["clr4"]  ?></p>
                </div>
            </div>

            <div class="row">
                <div id="color1" class="color_display item col-3 col-s-3" style="background-color:<?= $clr1 ?>"></div>
                <div id="color2" class="color_display item col-3 col-s-3" style="background-color:<?= $clr2 ?>"></div>
                <div id="color3" class="color_display item col-3 col-s-3" style="background-color:<?= $clr3 ?>"></div>
                <div id="color4" class="color_display item col-3 col-s-3" style="background-color:<?= $clr4 ?>"></div>
            </div>

            <div class="row">
                <div id="line" class="item col-12 col-s-12"></div>
            </div>

            <div class="row">
                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="trip_name">Trip Name:</label>
                        <input type="text" name="trip_name" id="trip_name" value="<?= $data["trip_name"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["trip_name"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="price">Price:</label>
                        <input type="text" name="price" id="price" value="<?= $data["price"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["price"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="date_from">Date from:</label>
                        <input type="text" name="date_from" id="date_from" value="<?= $data["date_from"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["date_from"] ?></p>
                </div>

                <div class="item col-3 col-s-6">
                    <p class="input_part" ><label for="date_to">Date to:</label>
                        <input type="text" name="date_to" id="date_to" value="<?= $data["date_to"] ?>"/>
                    </p>

                    <p class="important"><?= $errors["date_to"] ?></p>
                </div>
            </div>

            <div class="row">
                <div class="item col-12 col-s-12">
                    <p class="input_part" ><label for="description">Description:</label>
                        <textarea id="description" name="description" rows="5"><?= $data["description"] ?></textarea>
                    </p>

                    <p class="important"><?= $errors["description"] ?></p>
                </div>
            </div>

            <div class="row">
                <div class="item col-12 col-s-12">
                    <button id="btn">Submit</button>
                </div>
            </div>

        </form>
    </div>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
     $(document).ready(function () {
        $("#demo").click(function(){
            $("#city_name").val("Maui");
            $("#img1").val("/maui/maui1.jpg");
            $("#image1").attr("src", "<?= ASSETS_URL  . "images/maui/maui1.jpg" ?>");
            $("#img2").val("/maui/maui2.jpg");
            $("#image2").attr("src", "<?= ASSETS_URL  . "images/maui/maui2.jpg" ?>");
            $("#img3").val("/maui/maui3.jpg");
            $("#image3").attr("src", "<?= ASSETS_URL  . "images/maui/maui3.jpg" ?>");
            $("#img4").val("/maui/maui4.jpg");
            $("#image4").attr("src", "<?= ASSETS_URL  . "images/maui/maui4.jpg" ?>");
            $("#lon").val("20.7984");
            $("#lat").val("-156.3319");
            $("#clr1").val("#98DDCA");
            $("#color1").css("background-color", "#98DDCA");
            $("#clr2").val("#D5ECC2");
            $("#color2").css("background-color", "#D5ECC2");
            $("#clr3").val("#FFD3B4");
            $("#color3").css("background-color", "#98DDCA");
            $("#clr4").val("#FFAAA7");
            $("#color4").css("background-color", "#FFAAA7");
            $("#trip_name").val("Maui");
            $("#price").val("1000");
            $("#date_from").val("06.08.2021");
            $("#date_to").val("22.08.2021");
            $("#description").val('Maui, known also as “The Valley Isle,” is the second largest Hawaiian island. The island beloved for its world-famous beaches, the sacred Iao Valley, views of migrating humpback whales (during winter months), farm-to-table cuisine and the magnificent sunrise and sunset from Haleakala. It’s not surprising Maui has been voted "Best Island in the U.S." by Condé Nast Traveler readers for more than 20 years. Check out the regions of Maui and all this island has to offer.');
        });

        $("#clear").click(function(){
            $("#city_name").val("");
            $("#img1").val("");
            $("#image1").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
            $("#img2").val("");
            $("#image2").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
            $("#img3").val("");
            $("#image3").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
            $("#img4").val("");
            $("#image4").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
            $("#lon").val("");
            $("#lat").val("");
            $("#clr1").val("");
            $("#color1").css("background-color", "#1e2022");
            $("#clr2").val("");
            $("#color2").css("background-color", "#52616b");
            $("#clr3").val("");
            $("#color3").css("background-color", "#c9d6df");
            $("#clr4").val("");
            $("#color4").css("background-color", "#f0f5f9");
            $("#trip_name").val("");
            $("#price").val("");
            $("#date_from").val("");
            $("#date_to").val("");
            $("#description").val("");
        });

        $("#img1").blur(function(){
            $("#img_error1").text("");
            $.get("<?= BASE_URL . "api/image/add" ?>", {image: $("#img1").val()},
            function(data){
                if (data == 1){
                    $("#image1").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error1").text("Please enter an image.");
                } else if(data == 2){
                    $("#image1").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error1").text("Image does not exist.");
                } else {
                    $("#image1").attr("src", data);
                };
            });
        });

        $("#img2").blur(function(){
            $("#img_error2").text("");
            $.get("<?= BASE_URL . "api/image/add" ?>", {image: $("#img2").val()},
            function(data){
                if (data == 1){
                    $("#image2").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error2").text("Please enter an image.");
                } else if(data == 2){
                    $("#image2").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error2").text("Image does not exist.");
                } else {
                    $("#image2").attr("src", data);
                };
            });
        });

        $("#img3").blur(function(){
            $("#img_error3").text("");
            $.get("<?= BASE_URL . "api/image/add" ?>", {image: $("#img3").val()},
            function(data){
                if (data == 1){
                    $("#image3").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error3").text("Please enter an image.");
                } else if(data == 2){
                    $("#image3").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error3").text("Image does not exist.");
                } else {
                    $("#image3").attr("src", data);
                };
            });
        });

        $("#img4").blur(function(){
            $("#img_error4").text("");
            $.get("<?= BASE_URL . "api/image/add" ?>", {image: $("#img4").val()},
            function(data){
                if (data == 1){
                    $("#image4").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error4").text("Please enter an image.");
                } else if(data == 2){
                    $("#image4").attr("src", "<?= ASSETS_URL  . "images/travel.png" ?>");
                    $("#img_error4").text("Image does not exist.");
                } else {
                    $("#image4").attr("src", data);
                };
            });
        });

        $("#clr1").blur(function(){
            $("#clr1_error").text("");
            $.get("<?= BASE_URL . "api/color/add" ?>", {color: $("#clr1").val()},
            function(data){
                if (data == 1){
                    $("#color1").css("background-color", "#1e2022");
                    $("#clr1_error").text("Please enter a color value.");
                } else if(data == 2){
                    $("#color1").css("background-color", "#1e2022");
                    $("#clr1_error").text("Wrong hexed value.");
                } else {
                    $("#color1").css("background-color", data);
                };
            });
        });

        $("#clr2").blur(function(){
            $("#clr2_error").text("");
            $.get("<?= BASE_URL . "api/color/add" ?>", {color: $("#clr2").val()},
            function(data){
                if (data == 1){
                    $("#color2").css("background-color", "#52616b");
                    $("#clr2_error").text("Please enter a color value.");
                } else if(data == 2){
                    $("#color2").css("background-color", "#52616b");
                    $("#clr2_error").text("Wrong hexed value.");
                } else {
                    $("#color2").css("background-color", data);
                };
            });
        });

        $("#clr3").blur(function(){
            $("#clr3_error").text("");
            $.get("<?= BASE_URL . "api/color/add" ?>", {color: $("#clr3").val()},
            function(data){
                if (data == 1){
                    $("#color3").css("background-color", "#c9d6df");
                    $("#clr3_error").text("Please enter a color value.");
                } else if(data == 2){
                    $("#color3").css("background-color", "#c9d6df");
                    $("#clr3_error").text("Wrong hexed value.");
                } else {
                    $("#color3").css("background-color", data);
                };
            });
        });

        $("#clr4").blur(function(){
            $("#clr4_error").text("");
            $.get("<?= BASE_URL . "api/color/add" ?>", {color: $("#clr4").val()},
            function(data){
                if (data == 1){
                    $("#color4").css("background-color", "#f0f5f9");
                    $("#clr4_error").text("Please enter a color value.");
                } else if(data == 2){
                    $("#color4").css("background-color", "#f0f5f9");
                    $("#clr4_error").text("Wrong hexed value.");
                } else {
                    $("#color4").css("background-color", data);
                };
            });
        });

     });
    </script>
</body>
</html>