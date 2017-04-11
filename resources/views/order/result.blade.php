@extends('layout.app')
@section('content')
    <div class="mybox">
        <div>主人的私人空间地址</div>
        <div></div>
    </div>
    <div class="gatepwd">
        <div>大门密码</div>
    </div>
    <div class="roompwd">
        <div>
            房间密码
        </div>
    </div>
    <div>
        温馨提示
        私人空间密码仅在主人使用时段有效哦～
        主人要爱惜空间，尽量保持安静哦！
        <div class="mybox" id="countDown">
            使用计时
        </div>
    </div>
    <div class="mybox">
        <div class="mybtn-group">
            <button>遇到问题</button>
            <a href="/comment/0" class="btn btn-block">结束使用</a>
        </div>
    </div>
@endsection