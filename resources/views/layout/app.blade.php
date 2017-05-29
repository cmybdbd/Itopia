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
            background-color: white;
        }
        .lr{
            margin: 4.2vw 3.2vw 3.2vw 3.2vw;
        }
        .mybox {
            box-shadow: 0 0 6px #dddddd;
            margin: 4.2vw 4.2vw 4.2vw 4.2vw;
            padding: 1em;
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
            font-size: 1.8em;
        }
        .font-b {
            font-size: 1.4em;
        }
        .font-m{
            font-size: 1.2em;
        }
        .font-s{
            font-size: 0.85em;
        }
        .font-xs{
            font-size: 0.7em;
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
            background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, #1dccb8) , color-stop(80%, #1dccb8));
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
            display: inline-block;
            text-align: left;
        }

        .circle{
            width:100px;
            height:100px;
            background-color:#fff;
            border-style:solid;
            border-width: 2px;
            border-color:#1dccb8;
            border-radius:50px;
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