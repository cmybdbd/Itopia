@extends('layout.app')
@section('style')
    <style>
        .nav-pills > li.active{
            border: 1px var(--main-color) solid;
            border-radius: 4px;
            box-shadow: 0 1px 10px #eeeeee;
        }
        .nav-pills > li.active > a{
            color: var(--main-color);
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
                    <div id="durationTime" class="scrollPicker" data-content="1">
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
                <div class="mybox">
                    日期
                    <div id="dateTime" class="scrollPicker" data-content="{{$startNightTime}}">

                    </div>
                </div>
            </div>
        </div>

        <div>
            订单结算
        </div>
        <div class="mybox">
            总计
            <div id="totalPrice" class="present"></div>
        </div>
    </div>
    <div>
        <input type="checkbox" id="agreement">本人已获悉并同意《ITOPIA即时私人空间用户服务协议》
    </div>
    <div class="mybox">
        <div id="toPay">
            去支付
        </div>
    </div>
    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::user()->id}}"></div>
        <div id="roomId" data-content="{{$room->id}}"></div>
        <div id="exs" data-content="{{$olderOrder}}"></div>
    </div>
@endsection
@section('scripts')

    <script>
        $(function() {

            var startTime = $('#startTime'),
                durationTime = $('#durationTime'),
                endTime = $("#endTime"),
                dateTime = $("#dateTime");
            console.log(startTime.attr('data-content'));
            var startts = startTime.attr('data-content')*1000;
            var start = new Date(startts);
            function showHumanDay(ts)
            {
                return dateFormat(ts, "yyyy年mm月dd日");
            }
            function showHumanTime(ts)
            {
                return dateFormat(ts, 'yyyy年mm月dd日 HH:MM');
            }

            var todayts = startts - startts % (24*60*60*1000) - 8*60*60*1000;
            var tomorrowts = todayts + 24 * 60 * 60 * 1000;
            console.log(showHumanTime(todayts));
            var selectedDay = todayts, selectedTime;

            if(start.getMinutes() > 30)
            {
                ts = todayts + (start.getHours()+1.5)*60*60*1000;
                startTime.text(showHumanTime(ts))
                    .attr("data-content", ts);
            }
            else
            {
                ts = todayts  + (start.getHours()+0.5)*60*60*1000;
                startTime.text(showHumanTime(ts))
                    .attr("data-content", ts);
            }
            updateEndTime();
            updatePrice(0);

            var day = [{
                text: '今天',
                value: 0
            },{
                text: '明天',
                value: 1
            }];
            var date = [];
            for(i = 0;i < 2; i++)
            {
                date[i] = {
                    text: day[i].text + ' ' + dateFormat(startts+(day[i].value)*24*60*60*1000,'mm月dd日'),
                    value: i
                };
            }
            var time = [];
            for(i = 11;i <23;i++ )
            {
                time[(i-11)*2] = {
                    text: i +":00",
                    value: i
                };
                time[(i-11)*2+1] = {
                    text: i + ":30" ,
                    value: i+0.5
                }
            }
            var duration = [
                {
                    text: "1 小时",
                    value: 1
                },
                {
                    text: "1.5 小时",
                    value: 1.5
                },
                {
                    text: "2 小时",
                    value: 2
                }
            ];
            dateTime.text(date[0].text.split(' ')[1])
                .attr('data-content', duration[0].value);

            var startPicker = new Picker({
                data: [day, time],
                selectedIndex: [0, 0],
                title: '开始时间'
            });
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '使用时长'
            });
             datePicker = new Picker({
                data:[date],
                selectedIndex: [0],
                title: '选择日期'
            });

            startPicker.on('picker.select', function (selectedVal, selectedIndex) {
                var d = day[selectedIndex[0]].value;
                selectedDay = d === 0 ? showHumanDay(todayts) : showHumanDay(tomorrowts);
                startTime.text(selectedDay + ' ' + time[selectedIndex[1]].text)
                    .attr("data-content", (d===0 ? todayts : tomorrowts) + (time[selectedIndex[1]].value+0.5)*60*60*1000);

                updateEndTime();
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
                endTime.text(dateFormat((+startTime.attr("data-content")) + (+durationTime.attr("data-content")) * 60 * 60 * 1000,
                    'yyyy年mm月dd日 HH:MM'))
                    .attr('data-content', (+startTime.attr("data-content")) + (+durationTime.attr("data-content")) * 60 * 60 * 1000);
            }
            function updatePrice(page) {
                if(page === 0)
                    $("#totalPrice").text((+durationTime.attr("data-content")) * (+$("#hourPrice").attr("data-content")) );
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
            })
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>;

            $("#toPay").parent().on('click', function(){
                if(checkToPay())
                {
                    $data = {
                        _token: Laravel.csrfToken,
                        'userId': $("#userId").attr('data-content'),
                        'roomId': $("#roomId").attr('data-content'),
                        'startTime': (+startTime.attr('data-content'))/1000|0,
                        'endTime'  : (+endTime.attr('data-content'))/1000|0,
                        'duration' : +durationTime.attr('data-content'),
                        'payNum'   : +($('#totalPrice').text()),
                        'date'     : new Date().getTime()/1000|0,
                        'isDay'    : $('#byHour').hasClass('active')
                    };
                    exs =$("#exs").attr("data-content");
                    if( exs != "")
                    {
                        $data['uuid'] = JSON.parse(exs)['id'];
                    }
                    console.log($data);
                    console.log(startTime.attr('data-content'));
                    $.ajax({
                        url:'/order/create',
                        data: $data,
                        type: 'POST',
                        success: function(param){
                            console.log(param);
                          //  window.location.href = '/result/0';
                        },
                        error: function (e){
                            console.log(e.responseText);
                        }
                    });
                }
                    //window.location.href = 'result/0';
            })
        });
    </script>
    @endsection