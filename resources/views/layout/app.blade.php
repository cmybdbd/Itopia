<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Itopia</title>
    <link rel="stylesheet" href="/css/app.css">
    <style type="text/css">
        :root {
            --main-color: #1dccb8;
        }
        @font-face { font-family:Noto-Sans; src: url('font/NotoSans-Bold.ttf'); }
        body{
            background-color: white;
        }
        .mybox {
            box-shadow: 1vmin  1vmin  4vmin #dddddd;
            margin: 2vh;
            /*margin-bottom: 2vh;*/
            padding: 5vmin;
            /*
            display: flex;
            flex-wrap: wrap;
            */
        }
        .mybox .myrow{
            flex-basis: 100%;
            display: flex;
        }
        hr.mysplit {
            border: 0;
            height: 1px;
            background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%, var(--main-color)) , color-stop(80%, var(--main-color)));
            -moz-background-image: -moz-linear-gradient(left, transparent ,var(--main-color) 20%, var(--main-color) 80%, transparent 100%);
        }
        .mybtn-group{
            width: 100%;
            height: 10vh;
        }
        .mybtn-group button{
            border: none;
            border-right: 1px solid;
            background: transparent;
            cursor: pointer;
            border-image:
                    linear-gradient(transparent , #aeecc7 , transparent) 10% 100%;
            -moz-border-image:
                    -moz-linear-gradient(transparent,#aeecc7,transparent) 10% 100%;
            -webkit-border-image:
                    -webkit-linear-gradient(transparent,#aeecc7,transparent) 10% 100%;
            margin: 0 0 0 0;
            padding: 0;
            width: 50%;
            height: 100%;
            float: left;
        }
        .mybtn-group button:last-child{
            border-right: none;
        }
        .mybtn-group:after{
            content: "";
            clear:both;
            display: table;
        }
        .mybtn-group button:hover{
            background: #8c8b8b;
        }
        .scrollPicker, .present{
            float: right;
        }
        .scrollPicker:after{
            content:">";
        }
    </style>
    @yield('style')
</head>
<body>
@yield('content')
<script src="/js/app.js"></script>
@yield('scripts')
</body>
</html>