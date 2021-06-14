<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/trips.css" ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">

    <style>
        .search{text-align: left;}
    </style>
</head>
<body>
    <header >
            <h1 id="title">Paradise travel</h1>
            <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="Logo">
    </header>
    <nav>
        <?php  
            if (!isset($_SESSION['user'])) {
                 include("view/menu_not_logged.php"); 
            } elseif (isset($_SESSION['user'])){
                if($_SESSION['user']["role"] == 1){
                    include("view/menu_logged.php"); 
                } elseif($_SESSION['user']["role"] == 0){
                    include("view/menu_logged1.php"); 
                }
            }
        ?>
    </nav>

    <div class="row cards">
        <?php foreach ($cards as $card): ?>
            <div class="col-3 col-s-6" id="card_containter">
                <div class="card">
                    <form id="card_form" action="<?= BASE_URL . "trip/info" ?>" method="get" >
                        <input type="hidden" name="id" value="<?= $card["id"] ?>" />
                        <img class="card-image" src="<?= ASSETS_URL . "images" . $card["img"]?>" alt="<?= $card["name"] ?>">
                        <h1 class="card-header"><?= $card["name"] ?></h1>
                        <p class="card-rating">Rating <?= $card["rating"] ?> <i class="fa fa-star checked"></i></p>
                        <p class="card-price">Price: <?= $card["price"]?> &#8364</p>
                        <button class="card-button">Read more &#8594</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="col-12">
        <h2> University of Ljubjana FRI - ST </h2>
    </footer>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        function make_card(value){
            $card_containter = $('<div class="col-3 col-s-6" id="card_containter"></div>');
                        $card = $('<div class="card"></div>');
                        $form = $('<form id="card_form" action="<?= BASE_URL . "trip/info" ?>" method="get" > <form>');
                        $input = $('<input type="hidden" name="id" value="' + value["id"] +'" />');
                        $img = $('<img class="card-image" src="<?= ASSETS_URL . "images"?>'+ value["img"] + '" alt="'+ value["name"] +'">');
                        $h1 = $('<h1 class="card-header">' + value["name"]  + '</h1>');
                        $rating = $('<p class="card-rating">Rating ' + value["rating"] + ' <i class="fa fa-star checked"></i></p>');
                        $price = $('<p class="card-price">Price: ' + value["price"] + ' &#8364</p>');
                        $button = $('<button class="card-button">Read more &#8594</button>');

                        $form.append($input);
                        $form.append($img);
                        $form.append($h1);
                        $form.append($rating);
                        $form.append($price);
                        $form.append($button);

                        $card.append($form);
                        $card_containter.append($card);
                        $(".cards").append($card_containter);
        }


        $("#search-field").keyup(function() {
            $(".cards").empty();
            $.get("<?= BASE_URL ."api/trip/search" ?>", { query :  $(this).val()} ,
            function(data) {
                    $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                        make_card(value);
                    });
                });
            });

        $("#by_letter").click(function(){
            $(".cards").empty();
            $("#search-field").val('');
            $.get("<?= BASE_URL . "api/trip/by-letter" ?>", function(data){
                $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                    make_card(value);
                });
            })
        })

        $("#price_a").click(function(){
            $(".cards").empty();
            $("#search-field").val('');
            $.get("<?= BASE_URL . "api/trip/price" ?>", { query : $("#price_input").val()},
            function(data){
                $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                        make_card(value);
                });
            })
        });

        $("#by_rating").click(function(){
            $(".cards").empty();
            $("#search-field").val('');
            $.get("<?= BASE_URL . "api/trip/by-rating" ?>",
            function(data){
                console.log(data);
                $.each(JSON.parse(JSON.stringify(data)), function(index,value) {
                        make_card(value);
                });
            })
        });

    });
    </script>

</body>
</html>