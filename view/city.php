<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/city.css" ?>">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        body{background-color: <?= $city["c_palette"][3] ?>;}
        .btn { background-color: <?= $city["c_palette"][3] ?>; }
        ul { background-color: <?= $city["c_palette"][1] ?>; }
        .star {font-size: 30px;}
        .checked {font-size: 24px; color: orange;}
        #add_btn {background-color: rgb(201, 200, 198);}
        .edit_review {outline: none;border: none;width: 14%;font-size: 17px;padding: 4px;font-weight: bold;background-color:  rgb(201, 200, 198);transition: 0.5s;border-radius: 10px;}
        .edit_review:hover {background-color: #382a1dfa;color: white;border-radius: 20px;transform:  translateY(-0.5%);box-shadow: 0 0.8vh 0.8vh rgba(0, 0, 0, 0.5);}
    </style>

</head>
<body>
    
    <header style="background-color: <?= $city["c_palette"][0] ?>; ">
        <h1 id="title">Paradise travel</h1>
        <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="Logo">
    </header>

    <nav style="background-color: <?= $city["c_palette"][1] ?>; ">
        <ul>
            <li><a href="<?= BASE_URL . "home" ?>">Home</a></li>
            
            <?php if($city["booked"] == 0): ?>
                <li> <a id="book_link" >Book</a></li>
            <?php elseif ($city["booked"] == 1): ?>
                <li> <a href="<?= BASE_URL . "my/trips" ?>">My Trips</a></li>
            <?php endif; ?>

            <li> <a id="map_link" class="show_map">Show on Map</a></li>
            
            <?php include("view/log_menu.php");  ?>
        </ul>

    </nav>
    
    <div class="row content" style="background-color: <?= $city["c_palette"][2] ?>; ">
        <div class="img_text">
            <div class="col-7 images">
                <div class="container">
                    <img class="pic" src="<?= ASSETS_URL . "images" . $city["images"][0]?>" alt="City_Picture"> 
    
                    <a class="prev" onclick="next_image(-1)">&#10094;</a>
                    <a class="next" onclick="next_image(1)">&#10095;</a>
    
                    <div style="text-align:center">
                        <span class="dot" onclick="show_image_dot(0)"></span>
                        <span class="dot" onclick="show_image_dot(1)"></span>
                        <span class="dot" onclick="show_image_dot(2)"></span>
                        <span class="dot" onclick="show_image_dot(3)"></span>
                    </div>
                </div>
            </div>
    
            <div class="col-5">
                <div class="text">
                    <h1 class="city_name"><?= $city["name"] ?></h1>
                    <p class="city_info"><?= $city["description"] ?></p>
                    <p class="city_date"><?= $city["date_from"] ?> - <?= $city["date_to"] ?></p>
                    <p class="city_rating"><?= $city["rating"] ?> <i class="fa fa-star checked"></i></p>
                    <?php if(!empty($city["rated"])): ?>
                        <div class="rate">
                            <i id="star1" class="fa fa-star star" ></i>
                            <i id="star2" class="fa fa-star star" ></i>
                            <i id="star3" class="fa fa-star star" ></i>
                            <i id="star4" class="fa fa-star star" ></i>
                            <i id="star5" class="fa fa-star star" ></i>
                        </div>
                    <?php endif; ?>
                    <p class="city_price">Price: <?= $city["price"] ?> &#8364</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="buttons">
                <div class="btn-container">

                    <?php if($city["booked"] == 0): ?>
                        <button id="book_btn" class="btn">Book Now</button>
                    <?php elseif ($city["booked"] == 1): ?>
                        <button class="btn">Booked &#10003</button>
                    <?php endif; ?>


                    <button id="map_btn" class="btn show_map">Show on Map</button>
                    <button id="show_reviews" class="btn">Show Reviews</button>
                </div>
            </div>
        </div>

        <div id="reviews" class="col-10 col-s-10" style="background-color: <?= $city["c_palette"][0] ?>">
           
        </div>

    </div>

   <footer class="col-12" style="background-color: <?= $city["c_palette"][3] ?>; ">
        <h2> University of Ljubjana - ST </h2>
    </footer>   
    
    <form id="map_form" action="<?= BASE_URL . "trip/map" ?>" method="get">
        <input type="hidden" name="city_id" id="city_id" value="<?= $city["city_id"] ?>">
        <input type="hidden" name="trip_id" id="trip_id" value="<?= $city["trip_id"] ?>">
    </form>

    <form id="book_form" action="<?= BASE_URL . "trip/book" ?>" method="post">
        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION["user"]["user_id"] ?>">
        <input type="hidden" name="trip_id" id="trip_id" value="<?= $city["trip_id"] ?>">
    </form>
   

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        var index = 0;
        var arr = <?= json_encode($city["images"]); ?>;

        function next_image(n) {
            index += n;
            show_image();
        }

        function show_image() {
            var i;
            var dots = document.getElementsByClassName("dot");
            var pic = document.querySelector('.pic');

            if (index > arr.length - 1) { index = 0 }
            if (index < 0) { index = arr.length - 1 }

            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            var path = "<?php echo(ASSETS_URL . "images")?>";

            pic.setAttribute("src", path + arr[index]);
            dots[index].className += " active";
        }

        function show_image_dot(n) {
            var i;
            var dots = document.getElementsByClassName("dot");
            var pic = document.querySelector('.pic');
            index = n;
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            var path = "<?php echo(ASSETS_URL . "images")?>";

            pic.setAttribute("src", path + arr[index]);
            dots[index].className += " active";
        }

        var map = document.getElementById("map_form");
        document.getElementById("map_btn").onclick = function(){
            map.submit();
        };
        document.getElementById("map_link").onclick = function(){
            map.submit();
        };

        <?php if($city["booked"] == 0): ?>
            var book = document.getElementById("book_form");
            document.getElementById("book_btn").onclick = function(){
                book.submit();
            };
            document.getElementById("book_link").onclick = function(){
                book.submit();
            };
            
        <?php endif; ?>

        $(document).ready(function () {
            <?php if(!empty($city["rated"])): ?>
                $(".star").click(function(){
                    $.post("<?= BASE_URL . "api/trip/rate" ?>", { rating: $(this).attr("id"),
                    city_id : <?= $city["city_id"] ?>},
                    function(data){
                        $icon = $('<i class="fa fa-star checked">');
                        $(".city_rating").text('Rating: ' + data + ' ');
                        $(".city_rating").append($icon);
                        console.log(data);
                        $(".star").remove();
                    });
                });     
            <?php endif; ?>

            function make_review(data){
                $review = $('<div class="review"></div>');
                $text = $('<div class="review_text" style="float: left;"></div>');
                $h3 = $('<h3 id="user">' + data["username"] + '</h3>');
                $r = $('<p id="' + data["review_id"] + '" style="margin:6px;padding:5px;">' + data["review"] + '</p>');
                $text.append($h3);
                $text.append($r);
                $review.append($text);

                if(data["user"] == 1){
                    $btn_cont = $('<div class="btn_container" style="float:right"></div>');
                    $input1 = $('<input type="hidden" name="edit" class="edit_input" value="' + data["review_id"] + '">');
                    $edit_btn = $('<button id="' + data["review_id"] + '" class="edit_btn rev_btn"></button>');
                    $edit_icon = $('<i class="fa fa-edit"></i>');
                    $input2 = $('<input type="hidden" name="delete" class="delete_input" value="' + data["review_id"] + '">');
                    $del_btn = $('<button id="' + data["review_id"]  + '" class="del_btn rev_btn"></button>');
                    $del_icon = $('<i class="fa fa-trash"></i>');

                    $edit_btn.append($edit_icon);
                    $del_btn.append($del_icon);

                    $btn_cont.append($input1);
                    $btn_cont.append($edit_btn);
                    $btn_cont.append($input2);
                    $btn_cont.append($del_btn);
                    $review.append($btn_cont);
                }

               $("#reviews").append($review); 
            }

            function make_add_field(){
                $review = $('<div class="review"></div>');
                $input = $('<input class="add_review" id="add_review" type="text">');
                $btn = $('<button id="add_btn" class="add_btn" style="float:right;">Add Review</button>');
                $review.append($input);
                $review.append($btn);

                $("#reviews").append($review); 
            }

            $("#show_reviews").click(function(){
                if($(this).attr('id') == "show_reviews"){
                    $("#reviews").empty(); 
                    $("#show_reviews").text("Hide Reviews");
                    $("#show_reviews").attr("id", "hide");
                    $.get("<?= BASE_URL . "api/reviews" ?>", {city_id : <?= $city["city_id"] ?>} ,
                    function(data){

                        if(JSON.parse(JSON.stringify(data))[0]["only_add"] == 1){
                            if(JSON.parse(JSON.stringify(data))[0]["logged"] == 1){
                                make_add_field();
                            }
                        } else {
                            $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                            make_review(value);
                            var logged = value["logged"];
                            });
                            if(JSON.parse(JSON.stringify(data))[0]["logged"] == 1){
                                make_add_field();
                            }
                        }
                    });
                } else {
                    $("#hide").text("Show Reviews");
                    $("#hide").attr("id", "show_reviews");
                    $("#reviews").empty(); 
                }
            });

            $("#hide").click(function(){
                $("#reviews").empty(); 
                $("#hide").text("Show Reviews");
                $("#hide").attr("id", "show_reviews");
            });


            $(document).on("click", ".add_btn", function(){
                $.post("<?= BASE_URL . "api/reviews/add" ?>", 
                {review : $(".add_review").val(), city_id : <?= $city["city_id"] ?>},
                function(data){
                    if(data == 1){
                        alert("Please Enter a Review.");
                    } else if(data == 2){
                        $(".add_review").val(before_edit);
                        alert("Too many letters: maximum 300 allowed.");
                    } else {
                        $("#reviews").empty(); 
                        $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                            make_review(value);
                            var logged = value["logged"];
                        });
                        if(JSON.parse(JSON.stringify(data))[0]["logged"] == 1){
                            make_add_field();
                        }
                    }
                });
            });

            $(document).on("click", ".del_btn", function(){
                $.post("<?= BASE_URL . "api/reviews/delete" ?>",
                        { review_id : $(this).attr("id"), city_id : <?= $city["city_id"] ?>},
                        function(data){
                            $("#reviews").empty(); 
                            $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                                    make_review(value);
                                    var logged = value["logged"];
                                });
                            if(JSON.parse(JSON.stringify(data))[0]["logged"] == 1){
                                make_add_field();
                            }
                        });
            });

            var before_edit = "";

            $(document).on("click", ".edit_btn", function(){
                var id = $(this).attr("id");
                $(".add_review").val($("#" + id).text());
                $(".add_btn").text("Edit Review");
                $(".add_btn").attr("id", id);
                $(".add_btn").attr("class", "edit_review");
                before_edit = $(".add_review").val();
            });

            $(document).on("click", ".edit_review", function(){
                var id = $(this).attr("id");
                console.log(before_edit);
                $.post("<?= BASE_URL . "api/reviews/edit" ?>", 
                {review : $(".add_review").val(), city_id : <?= $city["city_id"] ?>, review_id: id},
                function(data){
                    console.log(data);
                    if(data == 1){
                        alert("Please Enter a Review.");
                    } else if(data == 2){
                        $(".add_review").val(before_edit);
                        alert("Too many letters: maximum 300 allowed.");
                    } else {
                        $("#reviews").empty(); 
                        $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                            make_review(value);
                            var logged = value["logged"];
                        });
                        if(JSON.parse(JSON.stringify(data))[0]["logged"] == 1){
                            make_add_field();
                        }
                    }
                });
            });
            

        });
    </script>
</body>
</html>