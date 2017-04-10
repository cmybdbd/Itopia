@extends('layout.app')
@section('style')

@endsection
@section('content')
    <div class="mybox">
        <div style="color:#000000;font-size: 1.14em">
            {{$room->title}}
        </div>
        <div style="color: #777777">
            地址：{{$room->address}}
        </div>
    </div>

    <div>
        <div>
            选择使用方式
        </div>
        <ul class="nav nav-pills" role="tablist" style="display:flex;justify-content: space-between">
            <li role="presentation" class="active">
                <a href="#byHour" aria-controls="byHour" role="tab" id="useHour"
                data-toggle="pill">
                    <div>分时使用</div>
                    <div>（11:00-23:00)</div>
                    <div id="hourPrice" data-content="{{$room->hourPrice}}">
                        {{$room->hourPrice}}/小时
                    </div>
                </a>
            </li>
            <li role="presentation">
                <a href="#byNight" aria-controls="byNight" role="tab" id="useNight"
                data-toggle="pill">
                    <div>预约包夜</div>
                    <div>（23:30 - 次日10：30）</div>
                    <div id="nightPrice" data-content="{{$room->nightPrice}}">
                        {{$room->nightPrice}}/夜
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            选择使用时间
            <div role="tabpanel" class="tab-pane active" id="byHour">
                <div class="mybox">
                    开始时间
                    <div id="startTime" class="scrollPicker">

                    </div>
                </div>
                <div class="mybox">
                    使用时长
                    <div id="durationTime" class="scrollPicker" data-content="1">
                        1 小时
                    </div>
                </div>
                <div class="mybox">
                    结束时间
                    <div id="endTime" class="present"></div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane " id="byNight">
                <div class="mybox">
                    日期
                    <div id="dateTime" class="scrollPicker"></div>
                </div>
            </div>
        </div>
    </div>
    <div>
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

@endsection
@section('scripts')

    <script>
        $(function() {
            var now = new Date();
            var todayH = dateFormat(now, "yyyy年mm月dd日"),
                today = dateFormat(now, "yyyy/mm/dd");
            var tomorrowH = dateFormat(new Date(now.getTime() + 24 * 60 * 60 * 1000), "yyyy年mm月dd日"),
                tomorrow = dateFormat(new Date(now.getTime() + 24 * 60 * 60 * 1000), "yyyy/mm/dd");

            var startTime = $('#startTime'),
                durationTime = $('#durationTime'),
                dateTime = $("#dateTime");
            var selectedDay = today, selectedTime;
            if(now.getMinutes() > 30)
            {
                startTime.text(todayH+(now.getHours()+1)+":30")
                    .attr("data-content",new Date(today  + ' ' + (now.getHours()+1)+":30:00").getTime());
            }
            else
            {
                startTime.text(todayH + now.getHours()+":30")
                    .attr("data-content", new Date(today  + ' ' + now.getHours()+":30:00").getTime());
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
            for(var i = 0;i < day.length; i++)
            {
                date[i] = {
                    text: day[i].text + ' ' + dateFormat(now.getTime()+(day[i].value)*24*60*60*1000,'mm月dd日'),
                    value: i
                };
            }
            var time = [];
            for(var i = 11;i <=23;i++ )
            {
                time[i-11] = {
                    text: i +':30',
                    value: i
                };
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
                selectedDay = d === 0 ? todayH : tomorrowH;
                startTime.text(selectedDay + ' ' + time[selectedIndex[1]].text)
                    .attr("data-content", new Date((d === 0 ? today : tomorrow) + ' ' + time[selectedIndex[1]].value +
                ':30:00').getTime());

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
                $("#endTime").text(dateFormat((+startTime.attr("data-content")) + (+durationTime.attr("data-content")) * 60 * 60 * 1000,
                    'yyyy年mm月dd日 HH:MM'));
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
            $("#toPay").parent().on('click', function(){
                if(checkToPay())
                    window.location.href = '/result/0';
            })
        });
    </script>
    @endsection