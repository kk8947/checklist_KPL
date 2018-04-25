
//服务器地址
var http = "http://127.0.0.1:18888/Checklist_Interface/index.php/Home/";

//时间戳转化成h:m:s的格式时间
function timetrans(date){
    var date = new Date(date*1000);//如果date为13位不需要乘1000
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var D = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate()) + ' ';
    var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
    var m = (date.getMinutes() <10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
    var s = (date.getSeconds() <10 ? '0' + date.getSeconds() : date.getSeconds());
    return h+m+s;
}

//获取当前日期
function timetrans_ymd(){
    var date = new Date();//如果date为13位不需要乘1000
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var D = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate()) + ' ';
    var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
    var m = (date.getMinutes() <10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
    var s = (date.getSeconds() <10 ? '0' + date.getSeconds() : date.getSeconds());
    return Y+M+D;
}


function test(){
	alert("111");
}

//id-名字转化
function exchange_project_id(name){
    var id = 0;
    switch(name){
        case "游击CHECK" :
            id = 1;
            break;

        case "AV控台区_大屏" :
            id = 2;
            break;

        case "AV控台区_灯光" :
            id = 3;
            break;

        case "公共信号字幕" :
            id = 4;
            break;

        case "公共信号赛前" :
            id = 5;
            break;

        case "公共信号赛后" :
            id = 6;
            break;

        case "公共信号音频" :
            id = 7;
            break;

        case "推流" :
            id = 8;
            break;

        case "推流周期1" :
            id = 9;
            break;

        case "推流周期2" :
            id = 10;
            break;

        case "推流周期3" :
            id = 11;
            break;

        case "推流周期4" :
            id = 12;
            break;

        case "赛事赛前" :
            id = 13;
            break;

        case "赛事进行" :
            id = 14;
            break;

        case "赛事赛后" :
            id = 15;
            break;

        case "票务&安保" :
            id = 16;
            break;

        case "采访席" :
            id = 17;
            break;

        case "内场" :
            id = 18;
            break;
    }
    return id;
}

//id-名字转化
function exchange_project_name(index){
    var name = "null";
    switch(index){
        case "1" :
            name = "游击CHECK";
            break;

        case "2" :
            name = "AV控台区_大屏";
            break;

        case "3" :
            name = "AV控台区_灯光";
            break;

        case "4" :
            name = "公共信号字幕";
            break;

        case "5" :
            name = "公共信号赛前";
            break;

        case "6" :
            name = "公共信号赛后";
            break;

        case "7" :
            name = "公共信号音频";
            break;

        case "8" :
            name = "推流";
            break;

        case "9" :
            name = "推流周期1";
            break;

        case "10" :
            name = "推流周期2";
            break;

        case "11" :
            name = "推流周期3";
            break;

        case "12" :
            name = "推流周期4";
            break;

        case "13" :
            name = "赛事赛前";
            break;

        case "14" :
            name = "赛事进行";
            break;

        case "15" :
            name = "赛事赛后";
            break;

        case "16" :
            name = "票务&安保";
            break;

        case "17" :
            name = "采访席";
            break;

        case "18" :
            name = "内场";
            break;
    }
    return name;
}

//id-code_e转化(第一张表)
function exchange_code_e_one(index){
    var code_e = 0;
    switch(index){
        case "1" :
            code_e = 11;
            break;

        case "2" :
            code_e = 12;
            break;

        case "3" :
            code_e = 13;
            break;

        case "4" :
            code_e = 34;
            break;

        case "5" :
            code_e = 30;
            break;

        case "6" :
            code_e = 7;
            break;

        case "7" :
            code_e = 24;
            break;

        case "8" :
            code_e = 14;
            break;

        case "9" :
            code_e = 25;
            break;

        case "10" :
            code_e = 25;
            break;

        case "11" :
            code_e = 25;
            break;

        case "12" :
            code_e = 25;
            break;

        case "13" :
            code_e = 24;
            break;

        case "14" :
            code_e = 14;
            break;

        case "15" :
            code_e = 4;
            break;

        case "16" :
            code_e = 17;
            break;

        case "17" :
            code_e = 11;
            break;

        case "18" :
            code_e = 8;
            break;
    }
    return code_e;
}

//id-code_s转化(第二张表)
function exchange_code_s_two(index){
    var code_e = 0;
    switch(index){
        case "1" :
            code_e = 12;
            break;

        case "2" :
            code_e = 13;
            break;

        case "5" :
            code_e = 31;
            break;

        case "17" :
            code_e = 12;
            break;
    }
    return code_e;
}

//id-code_e转化(第二张表)
function exchange_code_e_two(index){
    var code_e = 0;
    switch(index){
        case "1" :
            code_e = 19;
            break;

        case "2" :
            code_e = 19;
            break;

        case "5" :
            code_e = 38;
            break;

        case "17" :
            code_e = 17;
            break;
    }
    return code_e;
}

//id-副标题转化
function exchange_second_titel(index){
    var name = 0;
    switch(index){
        case "1" :
            name = "上海直播开始前30分钟导播车再检查";
            break;

        case "2" :
            name = "BP H5临时检查";
            break;

        case "5" :
            name = "上海直播开始前30分钟导播车再检查";
            break;

        case "17" :
            name = "采访前1分钟检查";
            break;
    }
    return name;
}
