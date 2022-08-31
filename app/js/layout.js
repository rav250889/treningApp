$(document).ready(function (){
   
    var disable = true;
        
    $("#hamburger-disable").click(function (){

        if(disable == true)
        {
            $("#hamburger-disable").attr("src", "../../img/hamburger-active.png");
            
            $("nav").show(200);
            
            disable = false;
        }
        
        else if(disable == false)
        {
            $("#hamburger-disable").attr("src", "../../img/hamburger-disable.png");
            
            $("nav").hide(200);
                        
            disable = true;
        }
    });
    
    $("#change").click(function (){
        let inputs = document.getElementsByClassName("change-data");
        
        for(let i = 0; i < inputs.length; i++)
        {
            inputs[i].disabled = false;
        }
        
        $("#settings div").css({"display": "block"});
        $("#settings div:nth-child(3) input").val("");
        
    });
    
    
});

