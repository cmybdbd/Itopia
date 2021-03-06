<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>蜗壳空间-按小时租的私人空间</title>
    <link rel="shortcut icon" href="{{asset('storage/logo.png')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{url('css/app.css')}}">
    <!--<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=b93c07bfd3e6dd8a6a9c61ca784c2cb5"></script>-->
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QAlK6BpG4luI1tu8ParPmfbA"></script>  
    <style type="text/css">
        :root {
            --main-color: #1dccb8;
            --f-font-color: #000000;
            --b-font-color: #777777;
            --used-color: #cccccc;
            --price-color: #ff0000;
        }
        /*@font-face { font-family:Noto-Sans; src: url('font/NotoSans-Bold.ttf'); }*/

        body{
            font-family: NexaLight,-apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; 
            background-color: white;
        }
        .lr{
            margin: 4.2vw 3.2vw 3.2vw 3.2vw;
        }
        .mybox {
            box-shadow: 0 0 6px #dddddd;
            margin: 12px 12px 12px 12px;
            padding: 0;
        }
        .flex-center{
            display: flex;
            justify-content: center;
        }
        .m-color {
            color: #1dccb8;
        }
        .u-color{
            color: #cccccc;
        }
        .font-xl {
            font-size: 17px;
        }
        .font-l {
            font-size: 16px;
        }
        .font-b {
            font-size: 1.4em;
        }
        .font-m{
            font-size: 14px;
        }
        .font-s{
            font-size: 12px;
        }
        .font-xs{
            font-size: 8px;
        }
        .b-color {
            color: #777777;
        }
        .f-color {
            color: #000000;
        }
        .w-color {
            color: #ffffff;
        }
        .custom-textarea{
            resize: none;
        }
        .mybox .myrow{
            flex-basis: 100%;
            display: flex;
        }
        hr.mysplit-color {
            border: 0;
            margin-top: 0;
            margin-bottom: 1em;
            height: 1px;
            /*background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%, var(--main-color)) , color-stop(80%, var(--main-color)));*/
            background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%,  #1dccb8) , color-stop(80%,  #1dccb8));
            -moz-background-image: -moz-linear-gradient(left, transparent ,var(--main-color) 20%, var(--main-color) 80%, transparent 100%);

        }
        hr.mysplit {
            border: 0;
            margin-top: 0;
            margin-bottom: 1em;
            height: 1px;
            /*background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%, var(--used-color)) , color-stop(80%, var(--used-color)));*/
            background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%, #cccccc) , color-stop(80%, #cccccc));
            -moz-background-image: -moz-linear-gradient(left, transparent ,var(--used-color) 20%, var(--used-color) 80%, transparent 100%);
        }

        .btn-main{
            color:white;
            width: 92.6%;
            margin:auto;
            font-size: 18px;
            height:44px;
            background-color: #1dccb8;
            border-radius: 22px;
            border-color: white;
        }

        .btn-main-secondary{
            width: 99px;
            color:#777777;
            font-size: 14px;
            height:44px;
            background-color: white;
            border-color: #1dccb8;
        }

        .btn-main-third{
            color:#eee;
            width: 92.6%;
            margin:auto;
            font-size: 18px;
            height:44px;
            background-color: #aaa;
            border-radius: 22px;
            border-color: #eee;
        }

        .btn-main-2{
            color:white;
            width: 46.3%;
            margin:auto;
            font-size: 16px;
            height:44px;
            background-color: #1dccb8;
            border-radius: 22px;
            border-color: white;
        }

        .btn-main-secondary-2{
            color:#aaa;
            width: 46.3%;
            margin:auto;
            font-size: 16px;
            height:44px;
            background-color: white;
            border-radius: 22px;
            border-color: #1dccb8;
        }

        .btn-main-3{
            color:white;
            width: 72px;
            font-size: 14px;
            height:28px;
            background-color: #1dccb8;
            border-radius: 14px;
            border-color: white;
        }


        .mybtn-group{
            width: 99%;
            height: 12vh;
        }
        .mybtn-group button, .mybtn-group div{
            border: none;
            background: transparent;
            cursor: pointer;
            position: relative;
            margin: 0 0 0 0;
            padding: 0;
            width: 50%;
            height: 100%;
            float: left;

            display: -webkit-flex;
            -webkit-flex-direction:column;
            -webkit-justify-content: center;
            -webkit-align-items: center;
            -webkit-box-flex: 1;
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }
        .mybtn-group button::after, .mybtn-group div::after{
            position: absolute;
            content: "";
            top: 8%;
            right: -1px;
            width: 1px;
            height: 84%;
            /*background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, var(--main-color)) , color-stop(80%, var(--main-color)));*/
            /*background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, #1dccb8) , color-stop(80%, #1dccb8));*/
        }
        .mybtn-group button:last-child::after, .mybtn-group div:last-child::after {
            content:"";
            background-image: none;
        }
        #param{
            display: none;
        }

        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                top: 30%;

                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            margin: auto;
            display: inline-block;
            text-align: left;
        }

        .button-available{
            background-color:#1dccb8;
            color:white;
            width:50px;
            height:20px;
            padding:2px 8px;
            border: 1px solid;
            border-radius:10px;
            justify-content: center;
        }

        .button-occupied{
            background-color:white;
            color:#cccccc;
            width:50px;
            height:20px;
            padding:2px 8px;
            border: 1px solid #cccccc;
            border-radius:10px;
            justify-content: center;
        }

        .circle{
            width:90px;
            height:90px;
            background-color:#fff;
            border-style:solid;
            border-width: 2px;
            border-color:#1dccb8;
            border-radius:50px;
        }

        #triangle-down-b {
            width:0px;height:0px;            
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 6px solid #777777;
        }

        #triangle-down-main {
            width:0px;height:0px;            
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 6px solid #1dccb8;
        }

        a{
            color:#777777;
        }

        a:active{
            color:#1dccb8;
            text-decoration : none;
        }

.nav-active{
    color:#1dccb8;
    z-index:100;
}

.nav-button-top:active{
    color:#1dccb8;
    z-index:100;
    /*box-shadow:rgba(29,204,184,1) 0px 3px 0px 0px;*/
}

.nav-button{
    z-index:10;
    box-shadow:rgba(228,228,228,1) 0px 2px 0px 0px;
}

.nav-button:active,.nav-button:hover{
    color:#1dccb8;
    z-index:100;
    box-shadow:rgba(29,204,184,1) 0px 3px 0px 0px;
}

.user:hover .user-nav {
  visibility:visible;
  opacity:1;
  top:25px;
}

.user-name{margin-top:1vh;font-size:14px;color:#777777; position:relative;}

.user-nav{text-align:center;z-index:1000;position:relative; visibility:hidden; opacity:0;-webkit-transition:all .15s; top:40px;-webkit-transform: translate3d(0, 0, 0)}

.user-nav ul{position:absolute; width:175px;background:#fff; left:-100px; color:#777; border-radius:10px;box-shadow:rgba(0,0,0,.3) 0px 2px 4px;}

.user-nav ul:after{
  content:"";
  display:block;
    width: 0; 
    height: 0; 
    border-left: 14px solid transparent;
    border-right: 14px solid transparent;
    border-bottom: 14px solid #fff;
  top: -15px;
  right: 20px;
  position:absolute;
}

.user-nav ul li {z-index:100;display:block; padding:10px; position:relative;
}

.user-nav ul li:first-child{border-radius:10px 10px 0 0}
.user-nav ul li:last-child{border-radius:0 0 10px 10px}

/*.user-nav ul li:hover,*/
.user-nav ul li:active{background:#1dccb8; color:#fff;-webkit-transition:all .15s;}

.user-nav ul li:hover,.user-nav ul li:active span{background-position-x:-20px;}

.modal-dialog{
    margin-top:72px;
}
.picker .picker-panel{
    height:206px !important;
}
</style>
    @yield('style')
</head>
<body>
@yield('content')
<div class="modal fade bs-example-modal-sm report-content" role="dialog">
    <div class="modal-dialog modal-sm" style="width:70%;" role="document">
    <div class="modal-content">
        <div class="modal-body" style="text-align: center;">
            <div style="margin-left:5%;margin-right:5%;">
                主人莫生气，电话联系小蜗 ({{\App\Utils\Constant::$REPORT_PHONE}}),或在后台留言，小蜗会神速回复
            </div>
            <hr class="mysplit" style="margin: 0.5em;">
            <button class="m-color font-m"
                    data-dismiss="modal"
                    style="border:none;width:100%;height:100%;background-color:white;">朕知道了</button>
        </div>
    </div>
    </div>
</div>


<div id="validatePhone" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <img data-dismiss="modal" src="{{asset('storage/map/cross.png')}}" style="cursor:pointer;position:absolute;width:20px;top:20px;right:20px;" alt="">
                <div class="m-color">
                    <h4 style="text-align: center;line-height:2em">注册/登录</h4>
                </div>
                <hr class="mysplit">
                <div class="modal-body">
                    <div class="input-group input-group-lg" style="width:277px;">
                        <input type="text" style="position:absolute;width:247px;font-size:14px;" class="form-control" id="phoneN" max="99999999999" placeholder="请输入您的11位手机号">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary btn-main-secondary" id="sendCode" type="button" style="z-index:11;margin-left:1px;border-radius: 10px;font-size:14px;">获取验证码</button>
                        </span>
                    </div>
                </div>
                <div class="" style="margin-left:18px;margin-right:18px;padding-bottom: 2.5em;display:flex; justify-content: space-around;">
                    @for($i = 0; $i < 4; $i ++)
                        <input type="text" id="inp{{$i}}" style="border-radius:8px;border: 1px solid #1dccb8;text-align: center;font-size:2em; width: 49px;">
                    @endfor
                </div>
                <p class="errormsg" style="color: red; position: absolute;left:1em;bottom: 0em;"></p>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="validateIdNumber" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="m-color">
                    <h4 style="text-align: center;line-height:2em">身份验证</h4>
                </div>
                <hr class="mysplit">
                <div class="modal-body">
                    <div class="input-group input-group-lg" >
                        <input type="text" class="form-control" id="RealId" placeholder="请输入身份证号">
                    </div>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="RealName" placeholder="请输入姓名">
                    </div>
                </div>
                    <button class="btn btn-default btn-main form-control font-b" style="height: 44px;width:100%" id="validateID">确 认</button>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="idNumberError" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="b-color" style="padding:1em 2em">主人, 你输入的身份证号有误哦！</div>
                </div>

                <div>
                    <button class="btn btn-default form-control m-color" style="height: 3em" id="">朕重新输入一遍</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!--
<div id="lng" data-content=""></div>
<div id="lat" data-content=""></div>
-->
<script src="{{url('js/app.js')}}"></script>
<script>
    $("#report").on('click',function () {
        $(".report-content").modal();
    });
   /* if( $('#lng').attr('data-content') == null || $('#lat').attr('data-content') == null)
    {
        
    /*new BMap.LocalCity().get(function (r) { //定位城市  
        alert("当前定位城市:" + r.name);  
    });
        new BMap.Geolocation().getCurrentPosition(function (r) { //定位位置  
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                $('#lng').attr('data-content',r.point.lng);
                $('#lat').attr('data-content',r.point.lat);
                //alert('您的位置：' + r.point.lng + ',' + r.point.lat);  
            }  
            else {  
                alert('failed' + this.getStatus());  
            }  
        }, { enableHighAccuracy: true })  
    //关于状态码  
    //BMAP_STATUS_SUCCESS   检索成功。对应数值“0”。  
    //BMAP_STATUS_CITY_LIST 城市列表。对应数值“1”。  
    //BMAP_STATUS_UNKNOWN_LOCATION  位置结果未知。对应数值“2”。  
    //BMAP_STATUS_UNKNOWN_ROUTE 导航结果未知。对应数值“3”。  
    //BMAP_STATUS_INVALID_KEY   非法密钥。对应数值“4”。  
    //BMAP_STATUS_INVALID_REQUEST   非法请求。对应数值“5”。  
    //BMAP_STATUS_PERMISSION_DENIED 没有权限。对应数值“6”。(自 1.1 新增)  
    //BMAP_STATUS_SERVICE_UNAVAILABLE   服务不可用。对应数值“7”。(自 1.1 新增)  
    //BMAP_STATUS_TIMEOUT   超时。对应数值“8”。(自 1.1 新增)
    }*/
</script>
@yield('scripts')
</body>
</html>