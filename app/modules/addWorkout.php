<div id="workout-container">
    <div id="workout-component">
        <h1>Dodaj ćwiczenie</h1>
        <form action="index.php?page=addWorkout" method="post">
            <div><label>Wybierz dzień tygodnia</label>
            <select name="days" id="days-list">
                <option hidden></option>
                <option value="monday">Poniedziałek</option>
                <option value="tuesday">Wtorek</option>
                <option value="wednesday">Środa</option>
                <option value="thursday">Czwartek</option>
                <option value="friday">Piątek</option>
                <option value="saturday">Sobota</option>
                <option value="sunday">Niedziela</option>
            </select></div>
            <div><label>Ćwiczenie</label><input type="text" name="workoutname"></div>
            <div><label>Ilość serii</label><input type="text" name="series"></div>
            <div><label>Ilość powtórzeń</label><input type="text" name="repetitions"></div>
            <div><input id="accetworkout" type="submit" name="accetworkout" value="Zapisz"></div>
            <div><input id="cancelworkout" type="submit" name="cancelworkout" value="Anuluj"></div>
        </form>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';

        if(isset($_POST['workoutname']) && isset($_POST['series']) && isset($_POST['repetitions']))
        {
            $workoutname = filter_var($_POST['workoutname'], FILTER_SANITIZE_STRING);
            $series = filter_var($_POST['series'], FILTER_SANITIZE_STRING);
            $repetitions = filter_var($_POST['repetitions'], FILTER_SANITIZE_STRING);
            $days = filter_input(INPUT_POST, 'days', FILTER_SANITIZE_STRING);

            if(!empty($workoutname) && !empty($series) && !empty($repetitions))
            {
     
                if(isset($_POST['accetworkout']))
                {
                    
                    if(is_numeric($series) && is_numeric($repetitions))
                    {
                        if($days != "")
                        {
                        $add_workout = new DB_query();
                        $add_workout->addworkout($workoutname, $series, $repetitions, $days);
                        header("Location: index.php");
                        }
                        else error ("Wybierz dzień tygodnia");
                    }
                    else error("Wprowdź cyfrę dla pola Ilość serii oraz ilość powtórzeń");
                }
            }
            else if(isset($_POST['cancelworkout'])) header("Location: index.php");
            else error("Uzupełnij wszytkie pola");
        }
    ?>
    </div>
</div>
