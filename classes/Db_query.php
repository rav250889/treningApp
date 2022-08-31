<?php
    require_once __DIR__.'/Db.php';
    
    class Db_query extends Db
    {
        public function authorization()
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/session.php';            
            
            if((isset($_POST['login']) && isset($_POST['password'])) || $_SESSION['logged'] == 1)
            {
                $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING); //bez pieczne filtrowanie loginu
                
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); //bezpieczne filtrowanie hasła
                
                if((!empty($login) && !empty($password))) //gdy coś jest wpisane lub gdy sesja jest aktywna
                { 
                    $result = mysqli_query($this->connectDb(), "SELECT login,firstname,lastname,email,password,rights FROM users WHERE login='$login'");
             
                    while($row = mysqli_fetch_assoc($result))
                    {
                        if(($login === $row['login'] && password_verify($password, $row['password'])) || $_SESSION['logged'] == 1)
                        {
                            start_session();
                            //to co dzieje się po zalogowaniu
                            $_SESSION['logged'] = 1;
                            
                            $_SESSION['login'] = $login;
                            
                            $_SESSION['firstname'] = $row['firstname'];
                            
                            $_SESSION['lastname'] = $row['lastname'];
                            
                            $_SESSION['email'] = $row['email'];
                            
                            $_SESSION['time'] = time();
  
                            if($row['rights'] == 1)
                            {
                                $query = mysqli_query($this->connectDB(), "SELECT path FROM addresses WHERE id=1");

                                $row = mysqli_fetch_assoc($query);

                                header($row['path']);
                            }
                            else
                            {
                                $query = mysqli_query($this->connectDB(), "SELECT path FROM addresses WHERE id=2");

                                $row = mysqli_fetch_assoc($query);

                                header($row['path']);
                            }      
                        }
                    } 
                } 
                if(empty($login) && empty($password) && $_SESSION['logged'] == 0) echo error("Wprowadź login i hasło"); //wyświetla błąd gdy nic nie jest wpisane
                
                if((!empty($login) && !empty($password)) && $_SESSION['logged'] == 0) echo error("Złe dane logowania"); // wyświetla błąd gdy są wpisane błędne dane logoweania
            }
        }
        
        public function getworkout()
        {   
            setcookie("id", $_GET['id']);
            
            echo
               "<div id='scrollTable'><table>
                <tr>
                    <th>Ćwiczenie</th>
                    <th>Ilość serii</th>
                    <th>Ilość powt.</th>
                    <th>Akcja</th>
                </tr>";

            $result = mysqli_query($this->connectDB(),"SELECT id,workoutname,series,repetitions FROM ".$this->get_day()." "
                                                                . "WHERE user_id=(SELECT id FROM users WHERE login='".$_SESSION['login']."')");
        
            while($row = mysqli_fetch_assoc($result))
            {
                $tbody = "<tr>"
                        . "<td>".$row['workoutname']."</td>"
                        . "<td>".$row['series']."</td>"
                        . "<td>".$row['repetitions']."</td>"
                        . "<td>"
                            . "<form action='index.php' method='get'>"
                            . "<div class='changes'><a href='?page=updateWorkout&id=".$row['id']."'><input class='update' type='button' value='Zmień'></a></div>"
                            . "<div class='changes'><a href='?page=deleteWorkout&id=".$row['id']."'><input class='delete' type='button' value='Usuń'></a></div>"
                            . "</form>"
                        . "</td>"
                  . "</tr>";           
            
                echo $tbody;  
            } 
            echo "</table></div>";
        }
        
        public function addworkout($workout,$series,$repetitions, $day)
        {            
   
            mysqli_query($this->connectDB(), "INSERT INTO $day (user_id,workoutname,series,repetitions) "
                                                        . "VALUES ((SELECT id FROM users WHERE login='".$_SESSION['login']."')"
                                                        . ",'$workout','$series','$repetitions')");
        }
        
        public function update_workout($workname, $series, $repetitions , $id)
        {                        
            if($workname != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET workoutname='$workname' WHERE id='$id'");
            }
            
            if($series != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET series='$series' WHERE id='$id'");
            }
            
            if($repetitions != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET repetitions='$repetitions' WHERE id='$id'");
            } 
        }
        
        public function delete_workout($id)
        {
            mysqli_query($this->connectDB(), "DELETE FROM ".$this->get_day()." WHERE id='$id'");
        }
        
        protected function get_day()
        {
            $day;
            if(Date("D") == "Mon") $day = "monday";
            if(Date("D") == "Tue") $day = "tuesday";
            if(Date("D") == "Wed") $day = "wednesday";
            if(Date("D") == "Thu") $day = "thursday";
            if(Date("D") == "Fri") $day = "friday";
            if(Date("D") == "Sat") $day = "saturday";
            if(Date("D") == "Sun") $day = "sunday";
            
            return $day;
        }
        
        public function change_user_data($firstname="", $lastname="", $email="", $old_password="", $new_password="")
        {            
            if($firstname != "" && $lastname != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET firstname='$firstname' WHERE login='".$_SESSION['login']."'");
                mysqli_query($this->connectDb(), "UPDATE users SET lastname='$lastname' WHERE login='".$_SESSION['login']."'");
            }
                       
            if($email != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET email='$email' WHERE login='".$_SESSION['login']."'");
            }
                       
            if($old_password != "" && $new_password != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET password='".password_hash($new_password, PASSWORD_ARGON2I)."' WHERE login='".$_SESSION['login']."'"); 
            }
        }
    }
?>
