<div id="delete-container">
    <div id="delete-component">
        <h1 id="question">Usunąć ćwiczenie?</h1>
        <form id="delete-form" action="index.php?page=deleteWorkout" method="post">
            <div><input id="delete" type="submit" name="deleteworkout" value="Tak"></div>
            <div><input id="cancel" type="submit" name="stillworkout" value="Nie"></div>
        </form>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
            
            $id = $_COOKIE['id'];
            
            if(isset($_POST['deleteworkout']))
            {
                 $delete = new DB_query();
                 $delete->delete_workout($id);
                 header("Location: index.php");
            }
            else if(isset($_POST['stillworkout'])) header("Location: index.php");
        ?>
    </div>
</div>
