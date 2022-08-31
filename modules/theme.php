<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Head.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Header.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Footer.php';
?>
<html lang="PL">
    <head>
        <?php
            $head = new Head("Tworzenie bazy danych", "/css/theme.css");
            $head->get_head();
            $head->additional_css("/css/createDbAndloginPanel.css");
        ?>
    </head>
    <body>
        <header>
            <?php
                $header = new Header("img/logo.png");
                $header->get_logo();
                $header->get_header();
            ?>
        </header>
        <?php
            if(!is_file("config/settings.php"))
            {
                include __DIR__.'/createDatabase.php';
            }
            else
                include __DIR__.'/loginPanel.php';
        ?>
        <footer>
            <?php
                $footer = new Footer();
                $footer->get_footer();
            ?> 
        </footer>
    </body>
</html>
