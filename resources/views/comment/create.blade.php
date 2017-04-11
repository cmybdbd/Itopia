@extends('layout.app')
@section('style')
    <link rel="stylesheet" href="/css/starrr.css">
    <style>
        .starrr  a{
            font-size:4em;
            color: var(--main-color);
        }
    </style>
@endsection
@section('content')
    <div>
        <div class="mybox">
            <div>
                感谢主人使用ITOPIA空间
            </div>
            <hr class="mysplit">
            希望主人能留下对ITopia的意见建议
            <br>
            填写就有机会获得小@送出的多小时免费体验哦
            <div class="starrr"></div>
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </div>
        <button class="btn btn-block btn-default">提交</button>
        <button class="btn btn-block btn-cancel">返回</button>
    </div>
@endsection
@section('scripts')
    <script src="/js/starrr.js"></script>
    <script>
    $('.starrr').starrr();
    </script>
@endsection