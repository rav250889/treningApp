<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Head.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Header.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Footer.php'; 
?>
<html lang="PL">
    <head>
        <?php
            $head = new Head("Plan ćwiczeń", "/css/theme.css");
            $head->get_head();
            $head->additional_css('/app/css/table.css');
            $head->additional_css('/app/css/menu.css');
            $head->additional_css('/app/css/logout.css');
        ?>
        <script src="/app/js/jquery.js" type="text/javascript"></script>
        <script src="/app/js/layout.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <?php
                $header = new Header("/img/logo.png");
                $header->get_logo();
                $header->get_header();
            ?>
            <form id="logout-form" action="/index.php" method="post">
                <div id="logout-container">
                    <input type="submit" value="<?php echo $_SESSION['login']?>" name="logout">
                </div>
            </form>
            <div id="hamburger-menu" style="display: none;">
                <img id="hamburger-disable" src="/img/hamburger-disable.png">
            </div>
        </header>
        <?php
            include __DIR__.'/menu.php';
            include __DIR__.'/workoutList.php'; 
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/logout.php';
            
            if($_POST['logout']) logout();
        ?>
        <footer>
            <?php
                $footer = new Footer();
                $footer->get_footer();
            ?> 
        </footer>
    </body>
</html>