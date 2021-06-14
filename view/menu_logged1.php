<style>
    #user{border-bottom: 1px solid #2b292b;}
</style>

<ul>
    <li><a class="active" href="<?= BASE_URL . "home" ?>">Home</a></li>
    <li> <a href="<?= BASE_URL . "my/trips" ?>">My Trips</a></li>
    <li> <a href="<?= BASE_URL . "add" ?>">Add Item</a></li>
    <li class="dropdown">
        <a class="dropbtn" href="#"> Filter</a>
        <div class="dropdown-content">
            <a id="by_letter">Alphabetically</a>
            <a id="by_rating">By Rating</a>
            
            <a id="price_a">Price higher than</a> 
            <input id="price_input" style="width: 50px; padding: 0"/>
        </div>
    </li>
    <li style="border:none"><input class="center" id="search-field" type="text" name="query" autocomplete="off" placeholder="Search..." style="float:left; text-align:left; margin-left:5px;"/></li>

    <li style="float:right; border-left:1px solid #cab155;"><a href="<?= BASE_URL . "logout" ?>">Logout</a></li>
    <li style="float:right; margin-right: 40px; font-size: 15px; color:#2b292b; border:none;"><p id="user">Welcome, <?= $_SESSION["user"]["name"] . " " . $_SESSION["user"]["surname"]?></p></li>
</ul>