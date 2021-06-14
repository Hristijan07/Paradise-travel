<ul>
    <li><a class="active" href="<?= BASE_URL . "home" ?>">Home</a></li>
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

    <li style="float:right"><a href="<?= BASE_URL . "login" ?>">Login</a></li>
</ul>