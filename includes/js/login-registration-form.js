
$(document).ready(function (){
    $('#Gruppe-button span').text("Benutzergruppe");
    document.getElementById('loginimg').setAttribute('src', "images/login.png");
    $('a#ui-id-1').css("color", "black");
    $('a#ui-id-2').css("color", "#e0e0e0");
    
    $('.login-form').click(function(){
        document.getElementById('loginimg').setAttribute('src', "images/login.png");
        $('a#ui-id-1').css("color", "black");
        $('a#ui-id-2').css("color", "#e0e0e0");
    });
    
    $('.register-form').click(function(){
        document.getElementById('loginimg').setAttribute('src', "images/register.png");
        $('a#ui-id-2').css("color", "black");
        $('a#ui-id-1').css("color", "#e0e0e0");
    });
    
    $("#loginbtn").click(function(){
        if ($("#loginbtn").hasClass("ui-icon-carat-u")) {
        $(".upperwrap").addClass("toggler");
        $("#loginbtn").removeClass("ui-icon-carat-u").addClass("ui-icon-user");   
        } else {
        $(".upperwrap").removeClass("toggler");
        $("#loginbtn").removeClass("ui-icon-user").addClass("ui-icon-carat-u");  
        $('html,body').scrollTop(0);
        }
    });
    
    if ( $(".groupwrapper").html().length !== 0 ) {
        $(".upperwrap").removeClass("toggler");
        $(".wrapper").addClass("disabledW");
        $(".groupwrapper").addClass("groupwrapper-active");
    };
    if( $(".groupwrapper").html().length === 0 ) {
        $(".wrapper").removeClass("disabledW");
        $(".groupwrapper").removeClass("groupwrapper-active");
    };
    
});


