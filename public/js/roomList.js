window.onload=function(){
    var date_time = new Date();
    var dayShift = document.URL[document.URL.length-1];
    if(!isNaN(dayShift))
      date_time.setTime(date_time.getTime() + dayShift * 24*60*60*1000);


    //定义星期
    var week;
    //switch判断
    switch (date_time.getDay()){
        case 1: week="星期一"; break;
        case 2: week="星期二"; break;
        case 3: week="星期三"; break;
        case 4: week="星期四"; break;
        case 5: week="星期五"; break;
        case 6: week="星期六"; break;
        default:week="星期天"; break;
    }

 //年
 var year = date_time.getFullYear();
  //判断小于10，前面补0
   if(year<10){
  year="0"+year;
 }

 //月
 var month = date_time.getMonth()+1;
  //判断小于10，前面补0
  //if(month<10){
//month="0"+month;
 //}

 //日
 var day = date_time.getDate();
  //判断小于10，前面补0
   //if(day<10){
  //day="0"+day;
 //}

 //时
 var hours =date_time.getHours();
  //判断小于10，前面补0
    if(hours<10){
  hours="0"+hours;
 }

 //分
 var minutes =date_time.getMinutes();
  //判断小于10，前面补0
    if(minutes<10){
  minutes="0"+minutes;
 }

 //秒
 var seconds=date_time.getSeconds();
  //判断小于10，前面补0
    if(seconds<10){
  seconds="0"+seconds;
 }

 //拼接时间

 var date_td = month+"月"+day+"日 ";

 date_time.setTime(date_time.getTime()+24*60*60*1000);//tomorrow
 var monthtm = date_time.getMonth()+1;
 var daytm = date_time.getDate();
 var date_tm = monthtm+"月"+daytm+"日 ";
 
 date_time.setTime(date_time.getTime()-2*24*60*60*1000);//yesterday
 var monthyt = date_time.getMonth()+1;
 var dayyt = date_time.getDate();
 var date_yt = monthyt+"月"+dayyt+"日 ";
 

 //显示在容器里
 var tm = document.getElementById("tomorrow");
 var yt = document.getElementById("yesterday");
 
 if(tm!=null){
    document.getElementById("tomorrow").innerHTML= date_tm;
 }
 if(yt!=null){
 document.getElementById("yesterday").innerHTML= date_yt;
 }
 var tags = document.getElementsByName("today");
 if(tags!=null){
    for(var i in tags){//对标签进行遍历 
        tags[i].innerHTML= date_td;
    }
 }
}
