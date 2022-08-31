<?php
    class ConfigFile
    {
        public function create_file() 
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
            
            if(isset($_POST['host']) && isset($_POST['userdb']) && isset($_POST['passworddb']) && isset($_POST['namedb']))
                {
                    if(!empty($_POST['host']) && !empty($_POST['userdb']) && !empty($_POST['passworddb']) && !empty($_POST['namedb']))
                    {
                        $dbAddress = filter_var($_POST['host'], FILTER_SANITIZE_STRING);
                        
                        $dbUsername = filter_var($_POST['userdb'], FILTER_SANITIZE_STRING);
                        
                        $dbPassword = filter_var($_POST['passworddb'], FILTER_SANITIZE_STRING);
                        
                        $dbName = filter_var($_POST['namedb'], FILTER_SANITIZE_STRING);
                        
                        $config = fopen($_SERVER['DOCUMENT_ROOT']."/config/settings.php", "a+");
                        
                        fwrite($config, '<?php'." \n".'$host = '."'$dbAddress'; \n".'$dbuser = '."'$dbUsername'; \n".'$dbpassword = '."'$dbPassword'; \n".'$dbname = '."'$dbName'; \n".'?>');
                        
                        fclose($config);

                        try
                        {
                            $create = new Db();
                            
                            $create->createBasicDatabase();
                            
                            header("Location: index.php");
                        }
                        catch(Exception $e)
                        {
                            unlink($_SERVER['DOCUMENT_ROOT']."/config/settings.php");

                            echo error("Odmowa destępu do bazy. Podaj poprawne dane.");
                        }   
                    }
                    else
                       echo error ("Podaj wszystkie dane");
                }
            }
    }