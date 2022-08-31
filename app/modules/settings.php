<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
    
    $change = new Db_query();
?>
<div>
<form id="settings" action="index.php?page=settings" method="post">
    <div>
        <input type="button" value="Zmień" id="change">
    </div>
    <div>
        <label>Imię i nazwisko</label><input class="change-data" type="text" value="<?php echo $_SESSION['firstname']." ".$_SESSION['lastname']?>" name="names" disabled>
    </div>
    <div>
        <label>Obecne Hasło</label><input class="change-data" type="password" value="1234567890" name="old-password" disabled>
    </div>
    <div style="display: none;">
        <label>Nowe Hasło</label><input class="change-data" type="password" name="new-password1">
    </div>
    <div style="display: none;">
        <label>Powtórz nowe hasło</label><input class="change-data" type="password" name="new-password2">
    </div>
    <div>
        <label>Email</label><input class="change-data" type="text" value="<?php echo $_SESSION['email'];?>" name="email" disabled>
    </div>
    <div style="display: none;">
        <input type="submit" value="Zapisz" name="save-changes">
    </div>
    <div style="display: none;">
        <input type="submit" value="Anuluj" name="decline-changes">
    </div>
</form>

<?php
    if(isset($_POST['save-changes']))
    {
        if(isset($_POST['names']))
        {
            $names = filter_var($_POST['names'], FILTER_SANITIZE_STRING);

            if(!empty($names))
            {
                $firstname = strtok($names, " ");
                $lastname = substr($names, strpos($names, " ") + 1);
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }
            else error ("Wprowadź imię i nazwisko");  
        }
        
        if(isset($_POST['email']))
        {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

            if(!empty($email))
            {
                $_SESSION['email'] = $email;
            }
            else error ("Wprowadź adres email");
        }
        
        if(isset($_POST['old-password']) && isset($_POST['new-password1']) && isset($_POST['new-password2']))
        {
            $old_password = filter_var($_POST['old-password'], FILTER_SANITIZE_STRING);
            $new_password1 = filter_var($_POST['new-password1'], FILTER_SANITIZE_STRING);
            $new_password2 = filter_var($_POST['new-password2'], FILTER_SANITIZE_STRING);

            if(!empty($old_password) && !empty($new_password1) && !empty($new_password2))
            {
                $result = mysqli_query($change->connectDb(), "SELECT password FROM users where login='".$_SESSION['login']."'");
                $row = mysqli_fetch_assoc($result);
                if(password_verify($old_password, $row['password']))
                {
                    $actual_password = $old_password;

                    if($new_password1 == $new_password2)
                    {
                        $new_password = $new_password2;
                    }
                    else error ("Nowe hasła nie są identyczne");
                }
                else error("Obecne hasło jest niepoprawne. Jeśli nie pamiętasz hasła przejdź <a href='?page=resetPassword'>tutaj</a>");
            }
        }
        if(!empty($email) && !empty($names))
        {
            $change->change_user_data($firstname, $lastname, $email, $actual_password, $new_password);
            header("Location: index.php?page=settings");
        }
    }
    if(isset($_POST['decline-changes']))
    {
        header("Location: index.php?page=settings");
    } 
?>
</div>

