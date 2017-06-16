
@extends('layout.app')

@section('content')
    <div class="content" style="height:100%;width:100%;">
        <div class="mybtn-group" style="position:fixed;z-index:1000;top:0px;width:100%;height:60px;">
            <div id="myOrder">
                <img src="{{asset('storage/map/myOrder.png')}}" style="z-index:1000;position:fixed;width:40px;top:24px;left:30px;" alt="">
                <span style="font-size:14px;font-weight:500;position:fixed;top:68px;left:22px;">我的订单</span>
            </div>
            <div id="equipment">
                <img src="{{asset('storage/map/questionMark.png')}}" style="z-index:1000;position:fixed;width:40px;top:24px;right:30px;" alt="">
                <span style="font-size:14px;font-weight:500;position:fixed;top:68px;right:22px;">使用指南</span>
            </div>
        </div>
            <!--onmouseover="getMousePos(event)"-->
        <div>
            <img id="mapImg" src="{{asset('storage/map/mapPKU.png')}}" style="position:absolute;top:-150px;left:-250px;z-index:-1;height:941px;width:1050px;overflow:scroll;">
            <div style="position:fixed;top:0px;width:100%;height:700px;z-index:10;" class="e"></div>

        <div id = "frl">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:250px;left:85px;width:45px;z-index:11;">
            <div>
                <span style="width:80px;position:absolute;top:265px;left:145px;font-size:14px;z-index:11;">芙蓉里 <span class="m-color" style="font-weight:600;">3</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:255px;left:125px;height:48px;z-index:10;">
            </div>
        </div>
        
        <div id = "dhzy">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:370px;left:140px;width:45px;z-index:11;">
            <div>
                <span style="width:90px;position:absolute;top:385px;left:200px;font-size:14px;z-index:11;">大河庄苑 <span class="m-color" style="font-weight:600;">8</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:375px;left:180px;width:130px;height:48px;z-index:10;">
            </div>
        </div>

        <div id = "zgy">
        <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:120px;left:430px;width:45px;z-index:11;">
        <div>
            <span style="width:80px;position:absolute;top:135px;left:490px;font-size:14px;z-index:11;">中关园 <span class="m-color" style="font-weight:600;">3</span> 间</span>
            <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:125px;left:470px;height:48px;z-index:10;">
        </div>
        </div>
<!--
        <div id = "kyxq"
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:470px;left:730px;width:45px;z-index:11;">
            <div>
                <span style="width:90px;position:absolute;top:490px;left:790px;font-size:14px;z-index:11;">科育小区 <span class="m-color" style="font-weight:600;">5</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:480px;left:770px;width:130px;height:48px;z-index:11;">
            </div>
        </div>
-->
        <div id = "dxy">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:430px;left:100px;width:45px;z-index:11;">
            <div>
                <span style="width:80px;position:absolute;top:445px;left:160px;font-size:14px;z-index:11;">稻香园 <span class="m-color" style="font-weight:600;">3</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:435px;left:140px;height:48px;z-index:10;">
            </div>
        </div>
    </div>
    <div style="position:fixed;width:100%;bottom:64px;z-index:100;">
        <div id='day' class="circle" style="text-align:center;position:absolute;bottom:0;left:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">时租</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">19 / 小时</p></div>
        <div id='night' class="circle" style="text-align:center;position:absolute;bottom:0;right:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">包夜</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">179 / 夜</p></div>
    </div>

    <div id="param">
        <div class="uid" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div class="uphoneN" data-content="{{\Illuminate\Support\Facades\Auth::user()->phonenumber}}"></div>
        <div class="uidN" data-content="{{\Illuminate\Support\Facades\Auth::user()->idnumber}}"></div>
    </div>

<div class="modal fade bs-example-modal-sm equipment-content" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="margin-left:42px;margin-right:42px;">
                <div class="modal-body">
                    <div style="margin-left:6px;margin-right:6px;text-align:center;">
                        <div class="font-l m-color" style="margin-bottom:18px;">使用指南</div>
                        <img data-dismiss="modal" src="{{asset('storage/map/cross.png')}}" style="cursor:pointer;position:absolute;width:20px;top:20px;right:20px;" alt="">
                        <div class="font-s m-color">【白天即时使用】</div>
                        <div class="font-s" style="margin-bottom:18px;line-height:160%;text-align:left;">
白天11:30-22:30的时间按小时下单使用，由于空间讲求即时使用，您不能跳过未被预约的时间段进行预约，如果您想来蜗壳这儿玩，就随时点进来看看房间是否可用吧！
                        </div>
                        <div class="font-s m-color">【晚上整夜预约】</div>
                        <div class="font-s" style="margin-bottom:18px;line-height:160%;text-align:left;">
晚上23:00-次日11:00的时间是全部属于您的，您可以预约今天起7天内的夜晚。
                        </div>
                        <div class="font-s m-color">【智能管理，一客一扫】</div>
                        <div class="font-s" style="margin-bottom:18px;line-height:160%;text-align:left;">
蜗壳私人空间采用O2O智能管理，没有前台，如果您在使用过程中有任何问题，可以在线联系客服或拨打电话13161953877，每一单结束后都会有保洁阿姨为您清扫房间。
<br><br>最后，小蜗想麻烦您，保持楼道的安静，也保持蜗壳私人空间的整洁卫生！
                        </div>
                        <div class="m-color font-s">感谢您对蜗壳私人空间的支持！<br>祝您使用愉快~</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="modal fade bs-example-modal-sm equipment-content" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div style="margin-left:5%;margin-right:5%;">
                        <div>
                        <div class="font-m m-color">基础设施</div>
                            <div class="center">
                            <p><img src="{{asset('storage/u340.png')}}" alt=""><span>懒人沙发</span></p>
                            <p><img src="{{asset('storage/u342.png')}}" alt=""><span>榻榻米</span></p>
                            <p><img src="{{asset('storage/u354.png')}}" alt=""><span>智能蓝牙投影</span></p>
                            <p><img src="{{asset('storage/u356.png')}}" alt=""><span>双人床</span></p>
                            <p><img src="{{asset('storage/u362.png')}}" alt=""><span>智能门锁</span></p>
                            <p><img src="{{asset('storage/u364.png')}}" alt=""><span>冰箱</span></p>
                            <p><img src="{{asset('storage/u370.png')}}" alt=""><span>空调</span></p>
                            <p><img src="{{asset('storage/u372.png')}}" alt=""><span>电吹风</span></p>
                            <p><img src="{{asset('storage/u374.png')}}" alt=""><span>洗衣机</span></p>
                            <p><img src="{{asset('storage/u382.png')}}" alt=""><span>24小时热水</span></p>
                            <p><img src="{{asset('storage/u384.png')}}" alt=""><span>Wi-Fi</span></p>
                            </div>
                        </div>
                        <div>
                            <div class="font-m m-color">有偿服务</div>
                            <div class="center">
                            <p><img src="{{asset('storage/u396.png')}}" alt=""><span>零食饮料</span></p>
                            <p><img src="{{asset('storage/u392.png')}}" alt=""><span>一次性洗漱用品</span></p>
                            <p><img src="{{asset('storage/u394.png')}}" alt=""><span>床品四件套</span></p>
                            </div>
                        </div>
                    </div>
                    <hr class="mysplit" style="margin: 0.5em;">
                    <button class="m-color font-m"
                            data-dismiss="modal"
                            style="border:none;width:100%;height:100%;background-color:white;">朕知道了</button>
                </div>
            </div>
        </div>
    </div>-->
@endsection
@section('style')
    <style>
        .equipment-content img{
            width: 2em;
        }
        .equipment-content div.center{
            padding-left: 0.7em;
        }
        .equipment-content p {
            font-size: 0.8em;
            display: inline-block;

            line-height: 1.2em;
            padding: 0.4em 0em;
            margin:0  0.25em;
            width: 45%;
        }
        .equipment-content p > img{
            margin-right: 0.4em;
        }
        .equipment-content p > span{
            text-align: center;
        }
        span.item{
            width: 15em;
        }
        span.room-state{
            height: 1.6em;
        }

        .e{
            background-image: -webkit-linear-gradient( top,#fff,transparent);
            -moz-background-image: -moz-linear-gradient( top,#fff,transparent);
            opacity:0.5;
        }

        /*.blend
        {
            overflow: hidden;
            background-size:1068px;
            background-image: url({{asset('storage/map/mapPKU.png')}}), -webkit-linear-gradient( top,#aaa,#000);
            -moz-background-image: url({{asset('storage/map/mapPKU.png')}}), -moz-linear-gradient( top,#aaa,#000);
            background-blend-mode: screen;
        }*/

    </style>
@endsection
@section('scripts')
    <script src="{{url('js/login.js')}}"></script>
    <script>
    //alert('今日(6月10日)17:30-22:00为内测时间，请非测试人员不要下单，否则后果自负！ps:先前已下订单不受影响');
    $("#equipment").on('click',function () {
        $(".equipment-content").modal('show');
    });
    $("#dxy").on('click',function () {
        //window.location.replace('/getDayRooms/dxy');
        window.location.href='/getDayRooms/dxy';
    });
    $("#dhzy").on('click',function () {
        //window.location.replace('/getDayRooms/dhzy');
        window.location.href='/getDayRooms/dhz9';
    });
    $("#kyxq").on('click',function () {
        //window.location.replace('/getDayRooms/kyxq');
        window.location.href='/getDayRooms/kyxq';
    });
    $("#frl").on('click',function () {
        //window.location.replace('/getDayRooms/frl');
        window.location.href='/getDayRooms/frl';
    });
    $("#zgy").on('click',function () {
        //window.location.replace('/getDayRooms/zgy');
        window.location.href='/getDayRooms/zgy';
    });
    </script>
@endsection