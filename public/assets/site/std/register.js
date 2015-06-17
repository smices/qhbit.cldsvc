$(document).ready(function(){

    $("#frmRegister").bind("submit", function (event) {
        event.preventDefault();

        var args = $('#frmRegister').serialize();

        $.post("/std/member", args, function(json){
            console.log(json);
            if(json.code == 0){
                $('#containerRegister').addClass("uk-hidden");
                $('#remoteResponse').removeClass("uk-hidden");
            }else{
                $("#responseErrorMessage").html(json.msg).show();
            }
        }, "json");

        return false;

    });

    $("#linkToDownPanel").click(function(){
        $('#remoteResponse').removeClass("uk-hidden");
		$('#containerRegister').addClass("uk-hidden");
		$('#containerDownload').addClass("uk-hidden");
    });

    $("#linkToRegister").click(function(){
        $('#containerRegister').removeClass("uk-hidden");
        $('#remoteResponse').addClass("uk-hidden");
		$('#containerDownload').addClass("uk-hidden");
    });

    $("#linkToDownload").click(function(){
        $('#containerDownload').removeClass("uk-hidden");
        $('#containerRegister').addClass("uk-hidden");
        $('#remoteResponse').addClass("uk-hidden");
    });


});
