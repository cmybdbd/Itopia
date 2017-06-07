$(function() {
            $("#tos").on('click',function(){
                $(".tos-content").modal();
            });
            $("#useHour").parent().click(function(e){
                $.ajax({
                    url: '/updatePageView/useHour',
                    type:'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content')
                    }
                });
            })
            $("#useNight").parent().click(function(e){
                $.ajax({
                    url: '/updatePageView/useNight',
                    type:'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content')
                    }
                });
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
                dateTime = $("#dateTime");
            console.log(startTime.attr('data-content'));
            //var startts = startTime.attr('data-content')*1000;
            var startts = $("#nextTime").attr('data-content')*1000;
            var isUsing = $("#isUsing").attr('data-content');
            var usingNight = JSON.parse($("#usingNight").attr("data-content"));
            if(startts == 0)
            {
                $("#useNight").click();
                //updatePrice(1);
                $("#useHour").parent().click(function(e){
                    e.preventDefault();
                    return false;
                })
                startts = new Date(dateFormat(new Date(), 'yyyy/mm/dd 00:00:00')).getTime();
            }

            var todayts, tomorrowts;
            var selectedDay = todayts, selectedTime;
            var istomorrow = false;
            if(dateFormat(startts, 'dd') > dateFormat(new Date(), 'dd'))
            {
                istomorrow = true;
            }

            todayts = new Date(dateFormat(startts, 'yyyy/mm/dd 00:00:00')).getTime();
            if(istomorrow)
            {
                todayts = todayts -24*60*60*1000;
            }

            tomorrowts = todayts + 24 * 60 * 60 * 1000;
            console.log(istomorrow)
            console.log(showHumanTime(startts));
            console.log(showHumanTime(todayts));

            startTime.text(showHumanHour(startTime.attr('data-content')*1000));
            console.log(startTime.attr("data-content"));
                //.attr("data-content", startts);
            updateEndTime();
            if($("#useNight").parent().hasClass('active'))
            {
                updatePrice(1);
            }
            else
            {
                updatePrice(0);
            }

            var daytime = [{
                text: '今天',
                value: 0,
                sub: [
                ]
            },{
                text: '明天',
                value: 1,
                sub: [

                ]
            }];
            var weekday = [
                '星期天',
                '星期一',
                '星期二',
                '星期三',
                '星期四',
                '星期五',
                '星期六'
            ];
            var date = [];
            for(i = 0;i < 2; i++)
            {
                date[i] = {
                    text: daytime[i].text + ' ' + dateFormat(todayts+i*24*60*60*1000,'mm月dd日'),
                    value: i
                };
            }
            console.log(startts);
            for(i = 2;i < 7; i++)
            {
                temp = new Date(startts + i * 24*60*60*1000);

                date[i] = {
                    text: weekday[temp.getDay()] + ' ' + dateFormat(temp,'mm月dd日'),
                    value: i
                };
                console.log(date[i]);
            }

            if(!istomorrow)
            {
                for(i = 0; i< 4; i++)
                {
                    temp = startts + i * 30*60*1000;
                    if(dateFormat(temp, 'HH') > 22)
                        break;
                    daytime[0].sub[i+1] = {
                        text: showHumanHour(temp),
                        value: i * 30*60*1000
                    };
                }
                for (i = 0; i< 4; i++)
                {
                    daytime[1].sub[i] = {
                        text: showHumanHour(tomorrowts + (22 + i) * 30*60*1000),
                        value: (22+i) * 30*60*1000
                    }
                }

            }
            else {
                for(i = 0; i< 5; i++)
                {
                    temp = new Date('2000/01/01 20:00:00').getTime() + i * 30*60*1000;

                    daytime[0].sub[i] = {
                        text: showHumanHour(temp),
                        value: i * 30*60*1000
                    };
                }
                console.log(daytime);
                for (i = 0; i< 4; i++)
                {
                    daytime[1].sub[i] = {
                        text: showHumanHour(tomorrowts + (22 + i) * 30*60*1000),
                        value: (22+i) * 30*60*1000
                    }
                }

            }

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

            var duration1h = [
                {
                    text: "1 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "尾单为默认时长",
                    value: 3*60*60*1000
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

            function creatList(obj, list){
                obj.forEach(function(item, index, arr){
                    var temp = {};
                    temp.text = item.text;
                    temp.value = item.value;
                    list.push(temp);
                })
            }
            var day = [];
            var time = [];

            creatList(daytime, day);

            creatList(daytime[istomorrow|0].sub, time);
            console.log(day);
            console.log(time);

            var startPicker = new Picker({
                data: [day, time],
                selectedIndex: [istomorrow|0, 0],
                title: '开始时间',
                id: 'startPicker'
            });

            //使用时长,因要处理尾单，生成多个picker
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '',
                id: 'durationPicker'
            });
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
            var datePicker = new Picker({
                data:[date],
                selectedIndex: [isUsing|0],
                title: '选择日期',
                id:'datePicker'
            });
            console.log('isusing='+isUsing);

            startPicker.on('picker.select', function (selectedVal, selectedIndex) {
                var d = day[selectedIndex[0]].value;
                selectedDay = d === 0 ? '今天' : '明天';
                startTime.text(selectedDay + ' ' + time[selectedIndex[1]].text)
                    .attr("data-content", (d===0 ? startts :tomorrowts) + time[selectedIndex[1]].value);

                updateEndTime();
            });
            startPicker.on('picker.change', function (index, selectedIndex) {
                if (index === 0){
                    firstChange();
                }

                function firstChange() {
                    time = [];
                    checked = [];
                    checked[0] = selectedIndex;
                    var firstDay = daytime[selectedIndex];
                    creatList(firstDay.sub, time);

                    startPicker.refillColumn(1, time);
                    if(selectedIndex != istomorrow)
                    {
                        $($("#startPicker ul")[1]).children().addClass('disable');
                    }
                    else
                    {
                        var lis = $($("#startPicker ul")[1]).children();
                        for(i =2 ;i < lis.length;i++)
                        {
                            $(lis[i]).addClass('disable');
                        }
                    }
                    startPicker.scrollColumn(1, 0);
                }

            });



            durationPicker.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration[selectedIndex[0]].text)
                    .attr('data-content', duration[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
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



            datePicker.on('picker.select', function (selectedVal, selectedIndex) {
                dateTime.text(date[selectedIndex[0]].text.split(' ')[1])
                    .attr('data-content', date[selectedIndex[0]].value);

                updatePrice(1);
            })
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
                    switch (tsum){
                        case 1:
                            //$("#totalPrice").css('visiblity','hidden');
                            $("#realPrice").text("19");
                            break;
                        case 2:
                            //$("#totalPrice").css('visiblity','hidden');
                            $("#realPrice").text("38");
                            break;
                        case 3:
                            //$("#totalPrice").css('visiblity','hidden');
                            $("#realPrice").text("57");
                            break;
                        case 4:
                            //$("#totalPrice").css('visiblity','visible');
                            $("#realPrice").text("72");
                            break;
                        case 5:
                            //$("#totalPrice").css('visiblity','visible');
                            $("#realPrice").text("85");
                            break;
                        case 6:
                            //$("#totalPrice").css('visiblity','visible');
                            $("#realPrice").text("96");
                            break;
                        default:
                            $("#realPrice").text("0");
                            break;
                    };
                    
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


            /*startTime.parent().on('click', function () {
                startPicker.show();
            });*/
            $(document).ready(function(){

                var st = $("#startTime").attr('data-content')*1.0;
                var ed = $("#endTime").attr('data-content')*1.0 / 1000;
                var room_type = $("#roomType").attr('data-content')*1.0;
                var stSecondsInDay = (st - 57600) % 86400;
                var edSecondsInDay = (ed - 57600) % 86400;
                var Day0 = ed - edSecondsInDay;
                console.log(showHumanHour(Day0*1000));
                /*if(stSecondsInDay > (20.5-room_type*0.5) * 3600){    
                    s = (Day0 - (2 - room_type) / 2.0) * 3600;
                     console.log(showHumanHour(s*1000));
                    $("#endTime").attr('data-content',s*1000);
                    $("#endTime").text(showHumanHour(s*1000));
                }*/ 
                    timeR = 22.5 - room_type*0.5 - st%86400 / 3600 - 8
                    //console.log(timeR);
                    if(timeR<=1){
                        alert('亲，今天的日间房已经来不及定了哦，请看看包夜吧');
                        window.location.href = window.location.href.replace('home','nightPage');
                    }
                    else if(timeR<1.5){
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

                    timeCount($("#timeCount"));

                var ed = $("#endTime").attr('data-content')*1.0 / 1000;
                var edSecondsInDay = (ed - 57600) % 86400;
               
                
                if(edSecondsInDay > 22.5 * 3600 || edSecondsInDay < 12.5 * 3600)
                {
                    console.log(edSecondsInDay/3600);
                    alert('已错过日间订单时间，切换为夜间模式');
                    window.location.replace('/nightPage');
                }
                
            });

            durationTime.parent().on('click',function () {
                var st = $("#startTime").attr('data-content')*1.0;
                var room_type = $("#roomType").attr('data-content')*1.0;
                timeR = 22.5 - room_type*0.5 - st%86400 / 3600 - 8
                    //console.log(timeR);
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
            dateTime.parent().on('click', function () {
                datePicker.show();
            });

            $("#toPay").on('click', function(){
                if(checkToPay() && $("#toPay button").text()!= '下单中...')
                {
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
                    if(!isNaN(dayShift))
                    {
                        st = startTime.attr('data-content')*1.0 + dayShift*86400;
                        ed = endTime.attr('data-content')/1000 + dayShift*86400;
                        dt = temptime/1000 + dayShift*86400;
                    }
                    else{
                        st = $("#startTime").attr('data-content')*1.0;
                        ed = $("#endTime").attr('data-content')*1.0;
                        dt = temptime/1000;
                    }
                
                    var stSecondsInDay = (st - 57600) % 86400;
                    var edSecondsInDay = (ed - 57600) % 86400;

                    edSecondsInDay -= $("#roomType").attr('data-content') / 2.0 *  3600

                    if(edSecondsInDay > 22.5 * 3600 || edSecondsInDay < 12.5 * 3600)
                    {
                        console.log(edSecondsInDay/3600);
                        alert('当日订单已满');
                        window.location.href = window.location.href.replace('home','dayPage');
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
                                alert('下单失败');
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
                    //window.location.href = 'result/0';
            });


            // ******************************
            //   disable date
            for (i = 0; i < 7; i++)
            {
                //console.log('date='+dateFormat(startts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00'))
                //console.log(usingNight.indexOf(dateFormat(todayts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00')))
                if(usingNight.indexOf(dateFormat(todayts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00')) != -1)
                {
                    $("#datePicker [data-val='"+(i)+"']").addClass('disable');
                }
                else
                {
                    if(dateTime.text() == '')
                    {
                        dateTime.text(date[i].text.split(' ')[1])
                            .attr('data-content', date[i].value);
                        if($("#useNight").parent().hasClass('active'))
                            updatePrice(1);
                    }
                }
            }

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

            // disable time
            if(istomorrow)
            {
                $($("#startPicker [data-val='0']")[0]).addClass('disable');
            }
            else {
                $($("#startPicker [data-val='1']")[0]).addClass('disable');
            }

            var lis = $($("#startPicker ul")[1]).children();
            for(i =2 ;i < lis.length;i++)
            {
                $(lis[i]).addClass('disable');
            }

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