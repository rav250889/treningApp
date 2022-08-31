<?php
    class Header
    {
        protected $logo;
        
        public function __construct($logo="")
        {
            $this->logo = $logo;
        }
        public function get_logo()
        {
            $logo =  $this->logo;
            
            echo "<div id='logo'><img src='$logo' alt='logo.png'></div>";
        }
        
        public function get_header()
        {
            $header = "<style>"
                    . "    *
                            {
                                margin: 0;
                                padding: 0;
                                box-sizing: border-box;
                            }

                            header
                            {
                                width: 99.6%;
                                margin-top: 0.2%;
                                margin-left: 0.2%;
                                margin-right: 0.2%;
                                border-top-right-radius: 5px;
                                border-bottom-right-radius: 5px;
                                background-color: #002a5a;
                            }
                            #logo img
                            {
                                width: 100%;
                            }
                            #logo
                            {
                                padding: 0.5%;
                                margin-left: 1%;
                                width: 25%;
                                display: inline-block;
                            }"
                    . "</style>";
            echo $header;
        }
    }
?>

