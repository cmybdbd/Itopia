@extends('layout.app')
@section('style')
    <style>
        .nav-pills > li.active{
            border: 1px var(--main-color) solid;
            border-radius: 4px;
            box-shadow: 0 1px 10px #eeeeee;
        }
        .nav-pills > li.active > a{
            color: var(--main-color) !important;
            background: transparent !important;
        }
        .nav-pills > li{
            width: 40%;

            border: 1px var(--used-color) solid;
            border-radius: 4px;
            box-shadow: 0 1px 10px #eeeeee;
        }
        .nav-pills > li > a{
            color: var(--used-color);
            background: transparent !important;
        }
        .nav-pills > li >a >div{
            text-align: center;
        }
        .scrollPicker, .present{
            float: right;
        }
        .scrollPicker:after{

            position: relative;
            left: 1em;
            content:">";

        }
        .selectPanel{

            margin-bottom: 1vh; !important;
            padding-left:0.8em;
            padding-top: 1em;
            padding-bottom: 1em;
            padding-right: 1.5em;
            position: relative;
        }
        .noPicker:after{
            content: ">";
            color: white;
            position: relative;
            left: 1em;
        }
        .cbox{
            position: relative;
        }
        #agreement{
            opacity:0;
        }
        .cbox label{
            position: absolute;
            width: 1.2em;
            height: 1.2em;
            top: 0.2em;
            left: -1px;
            background: white;
            border: 1px solid var(--b-font-color);
            border-radius:5px;
        }
        .cbox label:after{
            opacity : 0;
            content: '';
            position: absolute;
            width: 0.85em;
            height: 0.4em;
            background: transparent;
            top: 0.22em;
            left: 0.15em;
            border: 1px solid var(--main-color);
            border-top: none;
            border-right: none;
            transform:rotate(-45deg);
        }
        .cbox input[type=checkbox]:checked + label:after{
            opacity: 1;
        }
    </style>
@endsection
@section('content')
    <div class="mybox">
        <div class="f-color font-b">
            {{$room->title}}
        </div>
        <div class="b-color">
            地址：{{$room->address}}
        </div>
    </div>

    <div style="margin: 3vw;">
        <div class="m-color">
            选择使用方式
        </div>
        <ul class="nav nav-pills" role="tablist" style="margin-top: 2vh;display:flex;justify-content: space-between">
            <li role="presentation" class="active custom-li">
                <a href="#byHour" aria-controls="byHour" role="tab" id="useHour"
                data-toggle="pill">
                    <div>分时使用</div>
                    <div>(11:00-23:00)</div>
                    <div id="hourPrice" data-content="{{$room->hourPrice}}">
                        {{$room->hourPrice}}/小时
                    </div>
                </a>
            </li>
            <li role="presentation" class="custom-li">
                <a href="#byNight" aria-controls="byNight" role="tab" id="useNight"
                data-toggle="pill">
                    <div>预约包夜</div>
                    <div>(23:30 - 次日10:30)</div>
                    <div id="nightPrice" data-content="{{$room->nightPrice}}">
                        {{$room->nightPrice}}/夜
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content" style="margin-top: 3vw;">
            <div class="m-color">选择使用时间</div>
            <div role="tabpanel" class="tab-pane active" id="byHour">

                <div class="mybox selectPanel">
                    开始时间
                    <div id="startTime" class="scrollPicker" data-content="{{$startDayTime}}">

                    </div>
                </div>

                <div class="mybox selectPanel">
                    使用时长
                    <div id="durationTime" class="scrollPicker" data-content="3600000">
                        1 小时
                    </div>
                </div>
                <div class="mybox selectPanel">
                    结束时间
                    <div id="endTime" class="present noPicker">

                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane " id="byNight">
                <div class="mybox selectPanel">
                    日期
                    <div id="dateTime" class="scrollPicker" data-content="{{$startNightTime}}"></div>
                </div>
            </div>
        </div>

        <div class="m-color" style="margin-top: 3vw;">
            订单结算
        </div>
        <div class="mybox selectPanel">
            总计
            <div class="present" style="color: var(--price-color)">
                <span id="totalPrice"></span>元
            </div>
        </div>
    </div>
    <div class="cbox" style="margin: 3vw;">
        <input type="checkbox" id="agreement">
        <label for="agreement"></label>本人已获悉并同意《ITOPIA即时私人空间用户服务协议》
    </div>
    <div id="toPay" class="myTail font-b m-color" style="height:3em;margin-top: 2vh;box-shadow:0 -1px 6px #eeeeee">
        <button style="width: 100%;height: 100%; border:none;background:transparent">去支付</button>
    </div>
    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div id="roomId" data-content="{{$room->id}}"></div>
        <div id="exs" data-content="{{$olderOrder}}"></div>
        <div id="isUsing" data-content="{{$room->isUsing()}}"></div>
        <div id="nextTime" data-content="{{$room->nextTime()}}"></div>
        <div id="usingNight" data-content="{{$room->usingNight()}}"></div>
    </div>
@endsection
@section('scripts')

    <script>
        $(function() {
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

            var todayts, tomorrowts;
            var selectedDay = todayts, selectedTime;
            var istomorrow = false;
            if(dateFormat(startts, 'dd') > dateFormat(new Date(), 'dd'))
            {
                istomorrow = true;
            }

            todayts = new Date(dateFormat(startts, 'yyyy-mm-dd 00:00:00')).getTime();
            if(istomorrow)
            {
                todayts = todayts -24*60*60*1000;
            }

            tomorrowts = todayts + 24 * 60 * 60 * 1000;
            console.log(showHumanTime(startts));
            console.log(showHumanTime(todayts));


            startTime.text(showHumanTime(startts))
                .attr("data-content", startts);
            updateEndTime();
            updatePrice(0);

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
                    text: daytime[i].text + ' ' + dateFormat(startts+i*24*60*60*1000,'mm月dd日'),
                    value: i
                };
            }
            for(i = 2;i < 7; i++)
            {
                temp = new Date(startts + i * 24*60*60*1000);
                date[i] = {
                    text: weekday[temp.getDay()] + ' ' + dateFormat(temp,'mm月dd日'),
                    value: i
                };
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
                    temp = new Date('2000-01-01 20:00:00').getTime() + i * 30*60*1000;

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
                    text: "1 小时",
                    value: 60*60*1000
                },
                {
                    text: "1.5 小时",
                    value: 1.5*60*60*1000
                },
                {
                    text: "2 小时",
                    value: 2*60*60*1000
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
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '使用时长',
                id: 'durationPicker'
            });
            var datePicker = new Picker({
                data:[date],
                selectedIndex: [isUsing|0],
                title: '选择日期',
                id:'datePicker'
            });
            console.log('isusing='+isUsing);

            startPicker.on('picker.select', function (selectedVal, selectedIndex) {
                var d = day[selectedIndex[0]].value;
                selectedDay = d === 0 ? showHumanDay(startts) : showHumanDay(tomorrowts);
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
            datePicker.on('picker.select', function (selectedVal, selectedIndex) {
                dateTime.text(date[selectedIndex[0]].text.split(' ')[1])
                    .attr('data-content', duration[selectedIndex[0]].value);
                updatePrice(1);
            })
            function updateEndTime(){
                endTime.text(dateFormat((+startTime.attr("data-content")) + (+durationTime.attr("data-content")),
                    'yyyy年mm月dd日 HH:MM'))
                    .attr('data-content', (+startTime.attr("data-content")) + (+durationTime.attr("data-content")));
            }
            function updatePrice(page) {
                if(page === 0)
                    $("#totalPrice").text((+durationTime.attr("data-content"))/(3600*1000) * (+$("#hourPrice").attr("data-content")) );
                else
                    $("#totalPrice").text($("#nightPrice").attr("data-content"));
            }
            function checkToPay(){
                return $("#agreement").is(':checked') && $("#totalPrice").text() != undefined;
            }
            $("#useHour").click(function(){
                updatePrice(0);
            });
            $("#useNight").click(function(){
                updatePrice(1);
            });
/*
            picker.on('picker.change', function (index, selectedIndex) {
                console.log(index);
                console.log(selectedIndex);
            });

            picker.on('picker.valuechange', function (selectedVal, selectedIndex) {
                console.log(selectedVal);
                console.log(selectedIndex);
            });
*/
            startTime.parent().on('click', function () {
                startPicker.show();
            });
            durationTime.parent().on('click',function () {
                durationPicker.show();
            });
            dateTime.parent().on('click', function () {
                datePicker.show();
            });

            $("#toPay").on('click', function(){
                if(checkToPay())
                {

                    temptime = new Date(dateFormat(new Date(), 'yyyy-mm-dd 00:00:00')).getTime();
                    if(dateFormat(new Date(), 'HH') > 5)
                    {
                        temptime += 24*60*60*1000;

                    }
                    if(!$('#byHour').hasClass('active'))
                    {
                        temptime = tomorrowts + dateTime.attr('data-content') * 24*60*60*1000;
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': (temptime-30*60*1000)/1000|0,
                            'endTime'  : (temptime+21*30*60*1000)/1000|0,
                            'duration' : +durationTime.attr('data-content')/3600000,
                            'price'   : +($('#totalPrice').text()),
                            'date'     : temptime /1000|0,
                            'isDay'    : $('#byHour').hasClass('active') ? 1:0
                        };
                    }
                    else
                    {
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': (+startTime.attr('data-content'))/1000|0,
                            'endTime'  : (+endTime.attr('data-content'))/1000|0,
                            'duration' : +durationTime.attr('data-content')/3600000,
                            'price'   : +($('#totalPrice').text()),
                            'date'     : temptime /1000|0,
                            'isDay'    : $('#byHour').hasClass('active') ? 1:0
                        };
                    }

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
                        success: function(param){
                            console.log(param);
                            if(param['code'] == '200' && param['param']['code'] == 200)
                            {
                                window.location.href = param['param']['content']['payUrl'];
                                /*
                                window.location.href = window.location.href.replace(
                                    /create.* /,
                                    'result/'+param['orderId']
                                );
*/
                            }

                        },
                        error: function (e){
                            alert(e.responseText);
                            console.log(e.responseText);
                        }
                    });
                }
                    //window.location.href = 'result/0';
            });


            // ******************************
            //   disable date
            for (i = 0; i < 7; i++)
            {
                if(usingNight.indexOf(dateFormat(todayts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00')) != -1)
                {
                    $("#datePicker [data-val='"+i+"']").addClass('disable');
                }
                else
                {
                    if(dateTime.text() == '')
                    {
                        dateTime.text(date[i].text.split(' ')[1])
                            .attr('data-content', date[i].value);
                    }
                }
            }


            // disable time
            if(istomorrow)
            {
                $($("#startPicker [data-val='0']")[0]).addClass('disable');
            }
            else {
                $($("#startPicker [data-val='1']")[1]).addClass('disable');
            }

            var lis = $($("#startPicker ul")[1]).children();
            for(i =2 ;i < lis.length;i++)
            {
                $(lis[i]).addClass('disable');
            }

        });
    </script>
    @endsection