<div id="workout-container">
    <div id="workout-component">
        <h1>Zmień ćwiczenie</h1>
        <form action="index.php?page=updateWorkout" method="post">
            <div><label>Ćwiczenie</label><input type="text" name="workoutname"></div>
            <div><label>Ilość serii</label><input type="text" name="series"></div>
            <div><label>Ilość powtórzeń</label><input type="text" name="repetitions"></div>
            <div><input id="accetworkout" type="submit" name="accetworkout" value="Zapisz"></div>
            <div><input id="cancelworkout" type="submit" name="cancelworkout" value="Anuluj"></div>
        </form>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
               
        if(isset($_POST['workoutname']) || isset($_POST['series']) || isset($_POST['repetitions']))
        {
            $workoutname = filter_var($_POST['workoutname'], FILTER_SANITIZE_STRING);
            $series = filter_var($_POST['series'], FILTER_SANITIZE_STRING);
            $repetitions = filter_var($_POST['repetitions'], FILTER_SANITIZE_STRING);

            if(!empty($workoutname) || !empty($series) || !empty($repetitions))
            {
                if(isset($_POST['accetworkout']))
                {
                    if(((!is_numeric($repetitions)) && $repetitions != "") || ((!is_numeric($series)) && $repetitions != ""))
                    {
                        error("Pole ilość serii oraz ilość powtórzeń musi być liczbą");
                        exit();
                    }
                    else
                    {
                        $add_workout = new DB_query();
                        $add_workout->update_workout($workoutname, $series, $repetitions , $_COOKIE['id']);
                        header("Location: index.php");
                    }
                }
            }
            else if(isset($_POST['cancelworkout'])) header("Location: index.php");
            else
            {
                error("Wszystkie pola są puste");
                exit();
            }
        }
    ?>
    </div>
</div>
