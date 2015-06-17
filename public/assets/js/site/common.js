function getBuyBuyChat(){
    $.getJSON("http://buybuychat.com:8888/update/v1/latest?channel=stable&platform=android&callback=?", function(data){
        if(data.code == 0){
            location.href = data.msg.url;
        }else{
            console.log(data.msg)
        }
    });
}

function getBMS(){
    location.href = "http://bms.buybuychat.com/assets/dl/bms-1.0.5-release.apk";
}

