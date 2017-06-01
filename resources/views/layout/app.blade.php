<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>iTOPIA-随时随地的私人空间</title>
    <link rel="stylesheet" href="{{url('css/app.css')}}">
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
            background-color:#1dccb8;color:white;
        }

        .button-occupied{
            background-color:white;
            color:#cccccc;
            border-color:#cccccc;
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

        a:hover,a:active,a:after{
            color:#cccccc;
            text-decoration : none;
        }

.nav-button{
    z-index:10;
    box-shadow:rgba(228,228,228,1) 0px 2px 0px 0px;
}

.nav-button:hover,.nav-button:active{
    z-index:100;
    box-shadow:rgba(29,204,184,1) 0px 3px 0px 0px;
}

.user:hover .user-nav {
  visibility:visible;
  opacity:1;
  top:25px;
}

.user-name{margin-top:1vh;font-size:14px;color:#777777; position:relative;}

.user-nav{text-align:center;z-index:1;position:relative; visibility:hidden; opacity:0;-webkit-transition:all .15s; top:40px;-webkit-transform: translate3d(0, 0, 0)}

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

.user-nav ul li {display:block; padding:10px; text-transform:uppercase; position:relative;
}

.user-nav ul li:first-child{border-radius:10px 10px 0 0}
.user-nav ul li:last-child{border-radius:0 0 10px 10px}

/*.user-nav ul li:hover,*/
.user-nav ul li:active{background:#1dccb8; color:#fff;-webkit-transition:all .15s;}

.user-nav ul li:hover,.user-nav ul li:active span{background-position-x:-20px;}

        .blend
        {
            width:782px;
            height:540px;
            background:#de6e3d url("lighthouse.jpg") no-repeat center center;
        }
    
        .blend.multiply
        {
            background-blend-mode: multiply;
        }
    </style>
    @yield('style')
</head>
<body>
@yield('content')
<div class="modal fade bs-example-modal-sm report-content" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-body" style="text-align: center;">
            <div style="margin-left:5%;margin-right:5%;">
                主人莫生气，电话联系小i ({{\App\Utils\Constant::$REPORT_PHONE}}),或在后台留言，小i会神速回复
            </div>
            <hr class="mysplit" style="margin: 0.5em;">
            <button class="m-color font-m"
                    data-dismiss="modal"
                    style="border:none;width:100%;height:100%;background-color:white;">朕知道了</button>
        </div>
    </div>
    </div>
</div>
<script src="{{url('js/app.js')}}"></script>
<script>
    $("#report").on('click',function () {
        $(".report-content").modal();
    });
</script>
@yield('scripts')
</body>
</html>