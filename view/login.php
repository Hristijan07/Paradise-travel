<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise travel</title>
    <link rel="stylesheet" href="<?= ASSETS_URL . "css/login.css" ?>">
    <link rel="icon" type="img/png" href="<?= ASSETS_URL . "images/logo.png" ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

</head>
<body>

    <header >
            <a class="back" href="<?= BASE_URL . "home" ?>">&#10094;</a>
            <h1 id="title">Paradise travel</h1>
            <img id="logo" src="<?= ASSETS_URL . "images/logo.png" ?>" alt="Logo">
    </header>

    <div class="main row">
        <div class="left col-5 col-s-12">
            <div class="form_container">
                <form action="<?= BASE_URL . "login"  ?>" method="post">
                    <div class="fimg_container">
                        <img class="form_image" src="<?= ASSETS_URL . "images/travel.png" ?>" alt="Travel_image">
                    </div>

                    <div class="login_row">
                        <i class="fa fa-user" style="font-size:36px"></i>
                        <input type="text" name="username" placeholder="Username" value="<?= $username ?>" />
                    </div>

                    <div class="login_error">
                        <?php if (!empty($errorUsername)): ?>
                            <p class="important"><?= $errorUsername ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="passwd_row">
                        <i class='fas fa-lock' style='font-size:36px'></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>

                    <div class="passwd_error">
                        <?php if (!empty($errorPassword)): ?>
                            <p class="important"><?= $errorPassword ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="center"> <button>Sign In</button></div>

                    <div class="sign_up">
                        <p>Don't have an account? &nbsp <a href="<?= BASE_URL . "sign-up" ?>">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>

        <div class="right col-7 col-s-12">
            <div class="image">
                <img src="<?= ASSETS_URL . "images/travel.jpg" ?>" alt="Travel_image">
            </div>
        </div>
    
    
    </div>


</body>
</html>