$(function() {
            $("#tos").on('click',function(){
                $(".tos-content").modal();
            });

            $("#agreement").click(function(){
                if ($(this).is(':checked')) {
                    $('#toPay').addClass('btn-main');
                    $('#toPay').removeClass('btn-main-third');
                }
                else{
                    $('#toPay').removeClass('btn-main');
                    $('#toPay').addClass('btn-main-third');
                }
            });
            function showHumanDay(ts)
            {
                return dateFormat(ts, "yyyy年mm月dd日");
            }
            function showHumanTime(ts)
            {

                return dateFormat(ts, 'yyyy年mm月dd日 HH:MM');
            }
            function showHumanHour(ts)
            {
                return dateFormat(ts, 'HH:MM');
            }

            var startTime = $('#startTime'),
                durationTime = $('#durationTime'),
                endTime = $("#endTime"),
                remainOrderTime = $("#remainOrderTime"),
                dateTime = $("#dateTime");

            startTime.text(showHumanHour(startTime.attr('data-content')*1000));
            var room_type = $("#roomType").attr('data-content')*1.0;
            if(room_type==1)
                endstr="10:00";
            else
                endstr="10:30"
            console.log(startTime.attr("data-content"));
                //.attr("data-content", startts);

                t = remainOrderTime.attr('data-content');
                if(t<1){
                    ;
                }
                else if(t<1.5){
                        remainOrderTime.attr('data-content', '3600000');
                        endTime.text(endstr);
                    }
                    else if(t<2){
                        remainOrderTime.attr('data-content', '5400000');
                        endTime.text(endstr);
                    }
                    else{
                        remainOrderTime.attr('data-content', '7200000');
                        endTime.text(endstr); 
                    }

            updateEndTime();
          
            var duration = [
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "3 小时",
                    value: 3*60*60*1000
                },
                {
                    text: "4 小时",
                    value: 4*60*60*1000
                },
                {
                    text: "5 小时",
                    value: 5*60*60*1000
                },
                {
                    text: "6 小时",
                    value: 6*60*60*1000
                }
            ];

            var durationh5 = [
                {
                    text: "0.5 小时",
                    value: 0.5*60*60*1000
                },
                {
                    text: "尾单为默认时长",
                    value: 0.5*60*60*1000
                }
            ];

            var duration1h = [
                {
                    text: "1 小时",
                    value: 1*60*60*1000
                },
                {
                    text: "尾单为默认时长",
                    value: 1*60*60*1000
                }
            ];


            var duration1h5 = [
                {
                    text: "1.5 小时",
                    value: 1.5*60*60*1000
                },
                {
                    text: "尾单为默认时长",
                    value: 1.5*60*60*1000
                }
            ];

            var duration2h = [
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "尾单为默认时长",
                    value: 2*60*60*1000
                }
            ];
            
            var duration3h = [
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "3 小时",
                    value: 3*60*60*1000
                }
            ];
            
            var duration4h = [
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "3 小时",
                    value: 3*60*60*1000
                },
                {
                    text: "4 小时",
                    value: 4*60*60*1000
                }
            ];
            
            var duration5h = [
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "3 小时",
                    value: 3*60*60*1000
                },
                {
                    text: "4 小时",
                    value: 4*60*60*1000
                },
                {
                    text: "5 小时",
                    value: 5*60*60*1000
                }
            ];


            //使用时长,因要处理尾单，生成多个picker
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '',
                id: 'durationPicker'
            });
            /*
            var durationPickerh5 = new Picker({
                data: [durationh5],
                selectIndex: [0],
                title: '',
                id: 'durationPickerh5'
            });*/
            var durationPicker1h = new Picker({
                data: [duration1h],
                selectIndex: [0],
                title: '',
                id: 'durationPicker1h'
            });
            var durationPicker1h5 = new Picker({
                data: [duration1h5],
                selectIndex: [0],
                title: '',
                id: 'durationPicker1h5'
            });
            var durationPicker2h = new Picker({
                data: [duration2h],
                selectIndex: [0],
                title: '',
                id: 'durationPicker2h'
            });
            var durationPicker3h = new Picker({
                data: [duration3h],
                selectIndex: [0],
                title: '',
                id: 'durationPicker3h'
            });
            var durationPicker4h = new Picker({
                data: [duration4h],
                selectIndex: [0],
                title: '',
                id: 'durationPicker4h'
            });
            var durationPicker5h = new Picker({
                data: [duration5h],
                selectIndex: [0],
                title: '',
                id: 'durationPicker5h'
            });
            
/******************************************/

            durationPicker.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration[selectedIndex[0]].text)
                    .attr('data-content', duration[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            /*
            durationPickerh5.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(durationh5[selectedIndex[0]].text)
                    .attr('data-content', durationh5[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });*/
            durationPicker1h.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration1h[selectedIndex[0]].text)
                    .attr('data-content', duration1h[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            durationPicker1h5.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration1h5[selectedIndex[0]].text)
                    .attr('data-content', duration1h5[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            durationPicker2h.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration2h[selectedIndex[0]].text)
                    .attr('data-content', duration2h[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            durationPicker3h.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration3h[selectedIndex[0]].text)
                    .attr('data-content', duration3h[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            durationPicker4h.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration4h[selectedIndex[0]].text)
                    .attr('data-content', duration4h[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            durationPicker5h.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration5h[selectedIndex[0]].text)
                    .attr('data-content', duration5h[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
/************************************************/


            function updateEndTime(){
                //(istomorrow?'明天':'今天')+
                endTime.text(dateFormat((+startTime.attr("data-content")*1000) + (+durationTime.attr("data-content")),
                    ' HH:MM'))
                    .attr('data-content', (+startTime.attr("data-content")*1000) + (+durationTime.attr("data-content")));
            }
            function updatePrice(page) {
                if(page === 0)
                {
                    $("#totalPrice").text((+durationTime.attr("data-content"))/(3600*1000) * (+$("#hourPrice").attr("data-content")) );
                    tsum = durationTime.attr("data-content")/(3600*1000);
                    
                    userId = $("#userId").attr('data-content');
                    var p ;
                    $.ajax({
                        url:'/isFirstOrder/'+userId,
                        type: 'GET',
                        datatype: 'json',
                        success: function(reg){
                            p = reg;
                            //console.log(reg);
                        },
                        error: function (e){
                            //alert(e.responseText);
                            //console.log(e.responseText);
                        }
                    });
                    if(!p) //no order
                    {
                        switch (tsum){
                        case 5:
                            $("#realPrice").text("85");
                            break;
                        case 6:
                            $("#realPrice").text("96");
                            break;
                        default:
                            $("#realPrice").text("0");
                            break;
                        };
                    }
                    else{

                        switch (tsum){
                        case 0.5:
                            $("#realPrice").text("9.5");
                            break;
                        case 1:
                            $("#realPrice").text("19");
                            break;
                        case 1.5:
                            $("#realPrice").text("28.5");
                            break;
                        case 2:
                            $("#realPrice").text("38");
                            break;
                        case 3:
                            $("#realPrice").text("57");
                            break;
                        case 4:
                            $("#realPrice").text("72");
                            break;
                        case 5:
                            $("#realPrice").text("85");
                            break;
                        case 6:
                            $("#realPrice").text("96");
                            break;
                        default:
                            $("#realPrice").text("0");
                            break;
                    };
                    }
                    
                }
                else {

                    if (dateTime.text() !== "") {
                        $("#totalPrice").text($("#nightPrice").attr("data-content"));
                    }
                }
            }
            function checkToPay(){
                return $("#agreement").is(':checked') && $("#realPrice").text() != "";
            }


            $(document).ready(function(){

                var st = $("#startTime").attr('data-content')*1.0;
                //var ed = $("#endTime").attr('data-content')*1.0 / 1000;
                var room_type = $("#roomType").attr('data-content')*1.0;
                var stSecondsInDay = (st - 57600) % 86400;
                //var edSecondsInDay = (ed - 57600) % 86400;
                //var Day0 = ed - edSecondsInDay;
                //console.log(showHumanHour(Day0*1000));
                /*if(stSecondsInDay > (20.5-room_type*0.5) * 3600){    
                    s = (Day0 - (2 - room_type) / 2.0) * 3600;
                     console.log(showHumanHour(s*1000));
                    $("#endTime").attr('data-content',s*1000);
                    $("#endTime").text(showHumanHour(s*1000));
                }*/ 
                console.log('room_type = ' + room_type);
                    timeR = 22.5 - room_type*0.5 - st%86400 / 3600.0 - 8;
                    console.log('timeR = ' + timeR);
                    //if(timeR<0.5){
                        //alert('亲，今天的日间房已经来不及定了哦，请看看包夜吧1');
                        //window.location.href = window.location.href.replace('home','nightPage');
                    //}
                     if(timeR<1){
                        alert('亲，今天的日间房已经来不及定了哦，请看看包夜吧1');
                        window.location.href = window.location.href.replace('home','nightPage');
                        /*$('#durationTime').attr('data-content',1800000);
                        $('#durationTime').text('0.5小时');
                        durationPickerh5.show();*/
                    }
                    else if(timeR<1.5){
                        $('#durationTime').attr('data-content',3600000);
                        $('#durationTime').text('1小时');
                        durationPicker1h.show();
                    }
                    else if (timeR<2)
                    {
                        $('#durationTime').attr('data-content',5400000);
                        $('#durationTime').text('1.5小时');
                        durationPicker1h5.show();
                    }
                    else if (timeR<3)
                    {
                        durationPicker2h.show();
                    }
                    else if (timeR<4)
                    {
                        durationPicker3h.show();
                    }
                    else if (timeR<5)
                    {
                        durationPicker4h.show();
                    }
                    else if (timeR<6)
                    {
                        durationPicker5h.show();
                    }
                    else{
                        durationPicker.show();
                    }

                    timeCount($("#timeCount"));
                
            });

            durationTime.parent().on('click',function () {
                var st = $("#startTime").attr('data-content')*1.0;
                var room_type = $("#roomType").attr('data-content')*1.0;
                timeR = 22.5 - room_type*0.5 - st%86400 / 3600 - 8;
                    console.log('timeR= ' + timeR);
                    if(timeR<0.5){
                        alert('亲，今天的日间房已经来不及定了哦，请看看包夜吧2');
                        window.location.href = window.location.href.replace('home','nightPage');
                    }
                    else if(timeR<1){
                        durationPickerh5.show();
                    }
                    if(timeR<1.5){
                        durationPicker1h.show();
                    }
                    else if (timeR<2)
                    {
                        durationPicker1h5.show();
                    }
                    else if (timeR<3)
                    {
                        durationPicker2h.show();
                    }
                    else if (timeR<4)
                    {
                        durationPicker3h.show();
                    }
                    else if (timeR<5)
                    {
                        durationPicker4h.show();
                    }
                    else if (timeR<6)
                    {
                        durationPicker5h.show();
                    }
                    else{
                        durationPicker.show();
                    }
            });

            $("#toPay").on('click', function(){
                if(checkToPay() && $("#toPay button").text()!= '下单中...')
                {
                var r=confirm("请主人再次确认您的订单：\n"+$('#roomTitle').attr('data-content')+'\n'+
                    showHumanTime(startTime.attr('data-content')*1000) + '-' +showHumanHour(endTime.attr('data-content')*1.0)+"\n时租一旦支付成功将无法取消哟，主人确认支付吗")
                if (r==true)
                {
                    //alert('系统维护中，请您明日再订~');
                    //return;
                    $("#toPay button").text('下单中...');

                    temptime = new Date(dateFormat(new Date(), 'yyyy/mm/dd 00:00:00')).getTime();
                    if(dateFormat(new Date(), 'HH') > 5)
                    {
                        temptime += 24*60*60*1000;

                    }
                    console.log('temptime='+temptime);
                    // day
                    var dayShift = document.URL[document.URL.length-1];
                    var st,ed,dt;
                    /*if(!isNaN(dayShift))
                    {
                        st = startTime.attr('data-content')*1.0 + dayShift*86400;
                        ed = endTime.attr('data-content')/1000 + dayShift*86400;
                        dt = temptime/1000 + dayShift*86400;
                    }
                    else{
                        st = $("#startTime").attr('data-content')*1.0;
                        ed = $("#endTime").attr('data-content')*1.0;
                        dt = temptime/1000;
                    }*/
                    st = startTime.attr('data-content')*1.0;
                    ed = endTime.attr('data-content')/1000;
                    dt = temptime/1000;

                    var stSecondsInDay = (st - 57600) % 86400;
                    var edSecondsInDay = (ed - 57600) % 86400;

                    edSecondsInDay -= $("#roomType").attr('data-content') / 2.0 *  3600

                    if(edSecondsInDay > 22.5 * 3600 || edSecondsInDay < 12.5 * 3600)
                    {
                        console.log(edSecondsInDay/3600);
                        alert('当日订单已满');
                        window.location.href = '/home';
                    }
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': (+st)|0,
                            'endTime'  : (+ed)|0,
                            'duration' : +durationTime.attr('data-content')/3600000,
                            'price'   : +($('#realPrice').text()),
                            'date'     : dt|0,
                            'isDay'    : 1
                        };

                    exs =$("#exs").attr("data-content");
                    if( exs != "")
                    {
                        data['uuid'] = JSON.parse(exs)['id'];
                    }
                    console.log(data);
                    console.log(startTime.attr('data-content'));
                    $.ajax({
                        url:'/order/create',
                        data: data,
                        type: 'POST',
                        datatype: 'json',
                        success: function(param){
                            console.log(param);
                            if(param['code'] == '200' && param['param']['code'] == 200)
                            {

                                window.location.href = param['param']['content']['payUrl'];
                            }
                            else
                            {
                                $("#toPay button").text('下单失败');
                                console.log('下单失败');
                                window.location.href = window.location.href.replace('home','nightPage');
                            }

                        },
                        error: function (e){
                            alert(e.responseText);
                            alert("使用时间出错了亲～请刷新页面～");
                            //console.log(e.responseText);
                        }
                    });
                }
            }
            else{;}
            });
            
            var room_type = $("#roomType").attr('data-content')*1.0;
                
            /* disable duration
            for(i = 0;i < duration.length;i++)
            {
                if( dateFormat(startts+duration[i].value,'HH')>= 22.5-room_type/2)
                {
                    for (j = i; j< duration.length; j++)
                        $($("#durationPicker li")[j]).remove();
                    break;
                }
            }*/

});

var btn;
var clock = '';
var nums = 180;//3min

function timeCount(thisBtn){
    btn = thisBtn;
    btn.html('(3分0秒)');
    clock = setInterval(doLoop, 1000); //一秒执行一次
}

function doLoop(){
    var mins = 0;
    nums--;
    t = nums;
    while(t>=60)
    {
        mins++;
        t=t-60;
    }
    var secs = t;

    if(nums > 0){
        btn.html('('+mins+'分'+secs+'秒)');
    }else{
        //alert('已过期，请重新付款！');
        window.location.href='/home';
    }
}