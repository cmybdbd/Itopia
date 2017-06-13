@extends('layout.app')
@section('style')
    <style>
        form span{
            display: inline-block;
        }
        .input-price{margin-left:12px;border-radius:4px;border: 1px solid #777;text-align: center;font-size:16px;width: 75px;height:30px;}
        .input-phone{margin-left:12px;border-radius:4px;border: 1px solid #777;text-align: center;font-size:16px;width: 160px;height:30px;}
        .wheel-item{
            list-style-type:none;
        }
        .cancel{
            color:#aaa;
            font-size: 16px;
            height:44px;
            border: 1px solid #1dccb8;
            border-radius: 44px;
            width: 44.5% !important;
            margin-left:3.7%;
        }
        .cancel::after{
            background-image: none !important;
        }
        .confirm{
            color:white !important;
            font-size: 16px;
            height:44px;
            border: 1px solid #1dccb8;
            border-radius: 44px;
            width: 44.5% !important;
            margin-right:3.7%;
            background-color: #1dccb8;
        }
    </style>
@endsection

@section('content')
        <div class="font-b" style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">订单后台</div>
       
        <div>
             <div class="mybtn-group" style="z-index:0;top:44px;height:44px;background-color:white;">
            
            <div class="user nav-button" data-content="zgy" style="width:33%;height:44px;">
                <span class="room" style="margin-top: 2vh">中关园</span>
                <div id="triangle-down-b" style="position:absolute;right:14%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b33a-00163e028324" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b33a-00163e028324">A01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b33b-00163e028924" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b33b-00163e028924">A02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b33c-00163e028324" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b33c-00163e028324">A03室</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="frl" style="width:33%;height:44px;">
                <span class="room" style="margin-top: 2vh">芙蓉里</span>
                <div id="triangle-down-b" style="position:absolute;right:12%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-01163e028801" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-a09c-01163e028801">A01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-02163e028801" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-a09c-02163e028801">A02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-03163e028801" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-a09c-03163e028801">A03室</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="dhzy" style="width:34%;height:44px;">
                <span class="room" style="margin-top: 2vh">大河庄苑</span>
                <div id="triangle-down-b" style="position:absolute;right:10%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-01163e028206" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b09c-01163e028206">B01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-02163e028206" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b09c-02163e028206">B02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-03163e028206" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b09c-03163e028206">B03室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-04163e028206" data-toggle="pill" class="room font-xl m-color" href="#ae50f8da-225e-11e7-b09c-04163e028206">B04室</a></li>
                    </ul>
                </div>
            </div>
        </div>
<!--
    <ul class="nav nav-pills" role="tablist" style="overflow:auto;display:flex;justify-content: space-between">
        @foreach($rooms as $key => $room)
        <li role="presentation" class="{{$key == 0 ? 'active':''}}">
            <a href="#{{$room->title}}" aria-controls="{{$room->title}}" role="tab"
               data-toggle="pill">
                {{$room->title}}
            </a>
        </li>
        @endforeach
    </ul>
-->
    <div class="tab-content">
        @foreach($rooms as $key => $room)
        <div role="tabpanel" class="tab-pane {{$key == 0? 'active':''}}" id="{{$room->id}}">
              <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    房间基本信息
                </div>
          
                <form action="{{url('/manage/room')}}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$room->id}}">
                    <div class="mybox" style="box-shadow:none;">
                        <div style="margin-bottom:24px;"><span>时租</span><input type="text" class="input-price m-color" name="hourPrice" placeholder="{{$room->hourPrice}}" >
                            <div style="position:absolute;left:152px;top:138px;"><span>整租</span><input type="text" class="input-price m-color" name="nightPrice" placeholder="{{$room->nightPrice}}"></div>
                        </div>
                        <div><span>管理手机号</span><input type="text" class="input-phone  m-color" name="number" placeholder="{{$room->phoneOfManager}}">
                        <button class="btn btn-default btn-block btn-main-3"style="float:right;padding-top:0px;">确认</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="mysplit">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    白日房管理
                </div>
                <div class="mybox" style="box-shadow:none;">
                    <div>时间</div>
                    <div id="startDayTime" class="scrollPicker"></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:288px;width:25%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectDay" data-content="0">时间列表</button>
                    <div id="durationDayTime" class="scrollPicker"></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:288px;width:25%;left:46%;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectDayStart" data-content="0">开始时间</button>
                   
                    <div style="margin-top:24px;">时长</div>
                    <div id="durationNightTime" class="scrollPicker"></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:328px;width:55%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectTime" data-content="0">时长</button>
                <button id='dayUse' data-content='{{$room->id}}' class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;margin-top:-28px;">占用</button>
                </div>
                
            </div>
            <hr class="mysplit">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    夜晚管理
                </div>
                <div class="mybox" style="box-shadow:none;">
                <div>日期</div>
                    <div id="durationNight" class="scrollPicker"></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:422px;width:55%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectNight" data-content="0">选择日期</button>
                <button id='nightUse' data-content='{{$room->id}}' class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;margin-top:-24px;">占用</button>
                </div>
                <div id="isNightBook0{{$room->id}}" data-content="{{$room->isNightBooked(0) ? '1':'0'}}"></div>
                <div id="isNightBook1{{$room->id}}" data-content="{{$room->isNightBooked(1) ? '1':'0'}}"></div>
                <div id="isNightBook2{{$room->id}}" data-content="{{$room->isNightBooked(2) ? '1':'0'}}"></div>
                <div id="isNightBook3{{$room->id}}" data-content="{{$room->isNightBooked(3) ? '1':'0'}}"></div>
                <div id="isNightBook4{{$room->id}}" data-content="{{$room->isNightBooked(4) ? '1':'0'}}"></div>
                <div id="isNightBook5{{$room->id}}" data-content="{{$room->isNightBooked(5) ? '1':'0'}}"></div>
                <div id="isNightBook6{{$room->id}}" data-content="{{$room->isNightBooked(6) ? '1':'0'}}"></div>
                <div id="isNightBook7{{$room->id}}" data-content="{{$room->isNightBooked(7) ? '1':'0'}}"></div>
            </div>

        </div>
        @endforeach
    </div>
<?php 
    $tmp = strtotime(date("Y-m-d"));
    $stTime = $tmp + 23*3600;
    $edTime = $stTime + 12*3600;
?>
<div id="param">
    <div id="today0am" data-content="{{$tmp}}"></div>
    <div id="startNightTime" data-content="{{$stTime}}"></div>
    <div id="endNightTime" data-content="{{$edTime}}"></div>
</div>
@endsection
@section('scripts')
    <script>
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
/*time picker*/
    var duration = [
                {
                    text: '.5小时',
                    value: 0.5
                },
                {
                    text: '1小时',
                    value: 1
                },
                {
                    text: '1.5小时',
                    value: 1.5
                },
                {
                    text: '2小时',
                    value: 2
                },
                {
                    text: '2.5小时',
                    value: 2.5
                },
                {
                    text: '3小时',
                    value: 3
                },
                {
                    text: '3.5小时',
                    value: 3.5
                },
                {
                    text: '4小时',
                    value: 4
                }
            ];
            var durationTime = $('#DurationTime');
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '',
                id: 'durationPicker'
            });


            durationPicker.on('picker.select', function(selectedVal, selectedIndex){
                $('#selectTime').attr('data-content', duration[selectedIndex[0]].value);
                $('#selectTime').text(duration[selectedIndex[0]].text);
            });
            
            $('#selectTime').on('click',function () {
                durationPicker.show();
            });


 var date_time = new Date();  
    date_time.setTime(date_time.getTime());
    var pickerText =new Array(8);
    for (i = 0;i<=7;i++)
    {
        pickerText[i] = (date_time.getMonth()+1) + '月' + date_time.getDate()+'日';
        date_time.setTime(date_time.getTime() + 24*60*60*1000);
    }

/*day start time picker*/
/*time picker*/
    var startTime = [
                {
                    text: '11:30',
                    value: 11.5
                },
                {
                    text: '12:00',
                    value: 12
                },
                {
                    text: '12:30',
                    value: 12.5
                },
                {
                    text: '13:00',
                    value: 13
                },
                {
                    text: '13:30',
                    value: 13.5
                },
                {
                    text: '14:00',
                    value: 14
                },
                {
                    text: '14:30',
                    value: 14.5
                },
                {
                    text: '15:00',
                    value: 15
                },
                {
                    text: '15:30',
                    value: 15.5
                },
                {
                    text: '16:00',
                    value: 16
                },
                                {
                    text: '16:30',
                    value: 16.5
                },
                {
                    text: '17:00',
                    value: 17
                },
                {
                    text: '17:30',
                    value: 17.5
                },
                {
                    text: '18:00',
                    value: 18
                },
                {
                    text: '18:30',
                    value: 18.5
                },
                                {
                    text: '19:00',
                    value: 19
                },
                                {
                    text: '19:30',
                    value: 19.5
                },
                {
                    text: '20:00',
                    value: 20
                },
                {
                    text: '20:30',
                    value: 20.5
                },
                {
                    text: '21:00',
                    value: 21
                },
                {
                    text: '21:30',
                    value: 21.5
                }
            ];
            var startPicker = new Picker({
                data: [startTime],
                selectIndex: [0],
                title: '',
                id: 'startPicker'
            });


            startPicker.on('picker.select', function(selectedVal, selectedIndex){
                $('#selectDayStart').attr('data-content', startTime[selectedIndex[0]].value);
                $('#selectDayStart').text(startTime[selectedIndex[0]].text);
            });
            
            $('#selectDayStart').on('click',function () {
                startPicker.show();
            });


 var date_time = new Date();  
    date_time.setTime(date_time.getTime());
    var pickerText =new Array(8);
    for (i = 0;i<=7;i++)
    {
        pickerText[i] = (date_time.getMonth()+1) + '月' + date_time.getDate()+'日';
        date_time.setTime(date_time.getTime() + 24*60*60*1000);
    }

/*day date picker*/
    var DayDate = [
                {
                    text: "今日(" + pickerText[0] + ')',
                    value: 0
                },
                {
                    text: "明日(" + pickerText[1] + ')',
                    value: 1
                },
                {
                    text: pickerText[2],
                    value: 2
                },
                /*{
                    text: pickerText[3],
                    value: 3
                },
                {
                    text: pickerText[4],
                    value: 4
                },
                {
                    text: pickerText[5],
                    value: 5
                },
                {
                    text: pickerText[6],
                    value: 6
                },
                {
                    text: pickerText[7],
                    value: 7
                }*/
            ];
            var DayDatePicker = new Picker({
                data: [DayDate],
                selectIndex: [0],
                title: '',
                id: 'DayDatePicker'
            });


            DayDatePicker.on('picker.select', function(selectedVal, selectedIndex){
                $('#selectDay').attr('data-content', DayDate[selectedIndex[0]].value);
                $('#selectDay').text(DayDate[selectedIndex[0]].text);
            });
            

            $('#selectDay').on('click',function () {
                DayDatePicker.show();
            });


/*night date picker*/


    var NightDate = [
                {
                    text: "今日(" + pickerText[0] + ')',
                    value: 0
                },
                {
                    text: "明日(" + pickerText[1] + ')',
                    value: 1
                },
                {
                    text: pickerText[2],
                    value: 2
                },
                {
                    text: pickerText[3],
                    value: 3
                },
                {
                    text: pickerText[4],
                    value: 4
                },
                {
                    text: pickerText[5],
                    value: 5
                },
                {
                    text: pickerText[6],
                    value: 6
                },
                {
                    text: pickerText[7],
                    value: 7
                },
            ];
            var NightDatePicker = new Picker({
                data: [NightDate],
                selectIndex: [0],
                title: '',
                id: 'NightDatePicker'
            });


            NightDatePicker.on('picker.select', function(selectedVal, selectedIndex){
                $('#selectNight').attr('data-content', NightDate[selectedIndex[0]].value);
                $('#selectNight').text(NightDate[selectedIndex[0]].text);
            });
            

            $('#selectNight').on('click',function () {
                NightDatePicker.show();
            });

            $('#dayUse').on('click',function(){
                var st = $('#today0am').attr('data-content')*1.0 + $('#selectDay').attr('data-content')*86400 + $('#selectDayStart').attr('data-content') * 3600;
                var ed = st + $('#selectTime').attr('data-content') * 3600;
                //var r = confirm('是否确认占用'+ showHumanTime(st * 1000)+' - '+ showHumanTime(ed * 1000)+'?')
                //if(r == true)
                //{
                
                data = {
                    'roomId': $(this).attr('data-content'),
                    'startTime': st,
                    'endTime'  : ed,
                    'duration' : $('#selectTime').attr('data-content'),//+durationTime.attr('data-content')/3600000,
                    'isDay'    : 1
                    };
                console.log(data);
                $.ajax({
                    url:'/manage/fakeOrder',
                    data: data,
                    type: 'GET',
                    datatype: 'json',
                    success: function(param){
                        console.log(param);
                        //alert(' ');
                        if(param['code'] == '200')
                        {
                            alert('成功占用');
                            console.log(param);
                        }
                        else
                        {
                            alert('占用失败: '+param['param']);
                        }
                    },
                    error: function (e){
                         alert('failed');
                     }
                    });
            //}//confirm
            });

            $('#nightUse').on('click',function(){
                alert('click nightuse');
                data = {
                    'roomId': $(this).attr('data-content'),
                    'startTime': $('#endNightTime').attr('data-content')*1.0+ 86400 * $('#selectNight').attr('data-content'),
                    'endTime'  : $('#startNightTime').attr('data-content')*1.0 + 86400 * $('#selectNight').attr('data-content'),
                    'duration' : 12,//+durationTime.attr('data-content')/3600000,
                    'isDay'    : 0
                    };
                console.log(data);
                $.ajax({
                    url:'/manage/fakeOrder',
                    data: data,
                    type: 'GET',
                    datatype: 'json',
                    success: function(param){
                        console.log(param);
                        //alert(' ');
                        if(param['code'] == '200')
                        {
                            alert('成功占用');
                            console.log(param);
                        }
                        else
                        {
                            alert('failed '+param['param']);
                        }
                    },
                    error: function (e){
                         alert('failed');
                     }
                    });
            });

    </script>

@endsection