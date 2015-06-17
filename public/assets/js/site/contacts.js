$(document).ready(function(){

    $('#contactsSubmit').bind('click', function(){

        name = $('#name').val();
        email = $('#email').val();
        tel = $('#tel').val();
        msg = $('#msg').val();
        if('' == name){$('#name')[0].focus();return false;}
        if('' == email){$('#email')[0].focus();return false;}
        if('' == tel){$('#tel')[0].focus();return false;}
        if('' == msg){$('#msg')[0].focus();return false;}
        console.log($('#contacts-form').serialize());
        return false;
        $.post('/contacts', $('#contacts-form').serialize(), function(json){

        }, 'JSON');
    });
});