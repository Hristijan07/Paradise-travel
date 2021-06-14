<style>
    #user{border-bottom: 1px solid #2b292b;}
</style>

<?php if(!isset($_SESSION['user'])): ?>
    <li style="float:right"><a href="<?= BASE_URL . "login" ?>">Login</a></li>
<?php elseif (isset($_SESSION['user'])): ?>
  <li style="float:right; border-left:1px solid #cab155;"><a href="<?= BASE_URL . "logout" ?>">Logout</a></li>
    <li style="float:right; margin-right: 40px; font-size: 15px; color:#111011; border:none;"><p id="user">Welcome, <?= $_SESSION["user"]["name"] . " " . $_SESSION["user"]["surname"]?></p></li>
<?php else: ?>
 
<?php endif; ?>
