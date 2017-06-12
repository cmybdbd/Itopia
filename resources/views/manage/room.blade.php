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
                        <li><a aria-controls="ae50f8da-225e-11e7-b33a-00163e028324" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b33a-00163e028324">A01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b33b-00163e028924" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b33b-00163e028924">A02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b33c-00163e028324" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b33c-00163e028324">A03室</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="frl" style="width:33%;height:44px;">
                <span class="room" style="margin-top: 2vh">芙蓉里</span>
                <div id="triangle-down-b" style="position:absolute;right:12%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-01163e028801" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-a09c-01163e028801">A01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-02163e028801" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-a09c-02163e028801">A02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-a09c-03163e028801" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-a09c-03163e028801">A03室</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="dhzy" style="width:34%;height:44px;">
                <span class="room" style="margin-top: 2vh">大河庄苑</span>
                <div id="triangle-down-b" style="position:absolute;right:10%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-01163e028206" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b09c-01163e028206">B01室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-02163e028206" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b09c-02163e028206">B02室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-03163e028206" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b09c-03163e028206">B03室</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a aria-controls="ae50f8da-225e-11e7-b09c-04163e028206" data-toggle="pill" class="room font-xl m-color"href="#ae50f8da-225e-11e7-b09c-04163e028206">B04室</a></li>
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
                    <div id="durationDayTime" class="scrollPicker" data-content="" ></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:288px;width:55%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectDay">时间列表</button>
                    
                    <div style="margin-top:24px;">时长</div>
                    <div id="durationNightTime" class="scrollPicker" data-content="" ></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:328px;width:55%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectTime">时长</button>
                <button class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;margin-top:-28px;">使用</button>
                </div>
                
            </div>
            <hr class="mysplit">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    夜晚管理
                </div>
                <div class="mybox" style="box-shadow:none;">
                <div>日期</div>
                    <div id="durationNight" class="scrollPicker" data-content="" ></div>
                    <button class="btn btn-block btn-default btn-main-secondary" style="position:absolute;top:422px;width:55%;left:60px;height:32px;padding:0;color:#1dccb8;border: 1px solid #777;" id="selectNight">选择日期</button>
                <button class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;margin-top:-24px;">使用</button>
                </div>
                
            </div>
        </div>
        @endforeach
    </div>

@endsection
@section('scripts')
    <script>

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
                durationTime.attr('data-content', duration[selectedIndex[0]].value);
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
            var DayDateTime = $('#DurationDayTime');
            var DayDatePicker = new Picker({
                data: [DayDate],
                selectIndex: [0],
                title: '',
                id: 'DayDatePicker'
            });


            DayDatePicker.on('picker.select', function(selectedVal, selectedIndex){
                DayDateTime.attr('data-content', DayDate[selectedIndex[0]].value);
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
            var NightDateTime = $('#DurationNightTime');
            var NightDatePicker = new Picker({
                data: [NightDate],
                selectIndex: [0],
                title: '',
                id: 'NightDatePicker'
            });


            NightDatePicker.on('picker.select', function(selectedVal, selectedIndex){
                NightDateTime.attr('data-content', NightDate[selectedIndex[0]].value);
                $('#selectNight').text(NightDate[selectedIndex[0]].text);
            });
            

            $('#selectNight').on('click',function () {
                NightDatePicker.show();
            });
    </script>

@endsection