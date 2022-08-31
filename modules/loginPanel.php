<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
?>
<div id="container">
    <form action='index.php' method="post">
        <div><label>Nazwa użytkownika</label><input type="text" name="login"></div>
        <div><label>Hasło</label><input type="password" name="password"></div>
        <div><input type="submit" name="acceptlogin" value="Zaloguj"></div>
    </form>

        <?php
            $authorization = new DB_query();
            
            $authorization->authorization();
        ?>
</div>