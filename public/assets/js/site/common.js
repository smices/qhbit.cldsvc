/**
 * Check Remote file exists status
 * @param rUrl
 * @returns {boolean}
 */
function fileExists(ele, rUrl, m404, m503, m200){
    $.getJSON("/cp/tools/rfexists?file="+rUrl, function(resp){
        if(resp.code == 0){
            if(resp.msg == "200"){
                $('#'+ele).html(m200);
            }else if(resp.msg == "503"){
                $('#'+ele).html(m503);
            }
        }else{
            $('#'+ele).html(m404);
            console.log(resp.msg);
        }
    });
}//end
