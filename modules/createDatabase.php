<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/ConfigFile.php';
 
?>
<div id="container">
    <form action="index.php" method="post">
        <div><label>Serwer</label><input type="text" name="host"></div>
        <div><label>Użytkownik</label><input type="text" name="userdb"></div>
        <div><label>Hasło</label><input type="password" name="passworddb"></div>
        <div><label>Nazwa bazy danych</label><input type="text" name="namedb"></div>
        <div><input type="submit" name="acceptdb" value="Zapisz"></div>
    </form>
<?php
        $config = new ConfigFile();

        $config->create_file();
?>
</div>
