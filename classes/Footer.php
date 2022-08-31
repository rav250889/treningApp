<?php
    class Footer
    {
        public function get_footer()
        {
            $footer = "<style>"
                    . "    *
                            {
                                margin: 0;
                                padding: 0;
                                box-sizing: border-box;
                            }

                            footer
                            {
                                width: 99.6%;
                                border-top-right-radius: 5px;
                                position: fixed;
                                left: 0.2%;
                                right: 0.2%;
                                bottom: 0;
                                background-color: #002a5a;
                               
                                
                            }
                            footer p
                            {
                                color: #fff;
                                text-align: center;
                                font-family: sans-serif;
                                padding: 1%;
                                font-size: 80%;
                            }
                            "
                    . "</style>";
            $value = "<p>&copy; Created by Rafał Wałach | RWDesigner</p>";
            
            echo $footer, $value;
        }
    }
