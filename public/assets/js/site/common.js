/**
 * Check Remote file exists status
 * @param rUrl
 * @returns {boolean}
 */
function fileExists(ele, rUrl, m404, m503, m200){
    $.getJSON("/cp/rfexists?file="+rUrl, function(resp){
        if(resp.code == 0){
            if(resp.msg == "200"){
                $('#'+ele).html(m200);
            }else if(resp.msg == "503"){
                $('#'+ele).html(m503);
                console.log(m503);
            }
        }else{
            $('#'+ele).html(m404);
            console.log(resp.msg);
        }
    });
    /*
    $.ajax({
        url : rUrl,
        type : 'GHEAD',
        error : function(resp) {
            console.log(resp);
            if(404 == resp.statusCode()){
                console.log('404');
                $('#'+ele).html(emsg);
            }else{
                $('#'+ele).html(smsg);
            }
        },
        success : function(resp) {
            if(404 == resp.statusCode()){
                console.log('404');
                $('#'+ele).html(emsg);
            }else{
                console.log(resp);
                $('#'+ele).html(smsg);
            }
        }
    }, 'JSONP');
    */
}//end
