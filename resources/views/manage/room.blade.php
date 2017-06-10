@extends('layout.app')
@section('style')
    <style>
        form span{
            display: inline-block;
        }
        .input-price{border-radius:8px;border: 1px solid #777;text-align: center;font-size:16px;width: 84px;height:30px;}
        .input-phone{border-radius:8px;border: 1px solid #777;text-align: center;font-size:16px;width: 160px;height:30px;}
    </style>
@endsection

@section('content')
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

    <div class="tab-content">
        @foreach($rooms as $key => $room)
        <div role="tabpanel" class="tab-pane {{$key == 0? 'active':''}}" id="{{$room->title}}">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    房间基本信息
                </div>
                <div class="mybox" style="box-shadow:none;">
                <form action="{{url('/manage/room')}}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$room->id}}">
                    <div class="row">
                        <div style="margin-bottom:24px;"><span>时租</span><input type="text" class="input-price" name="hourPrice" placeholder="{{$room->hourPrice}}" >
                            <div style="float:right;"><span>整租</span><input type="text" class="input-price" name="nightPrice" placeholder="{{$room->nightPrice}}"></div>
                        </div>
                        <div><span>管理手机号</span><input type="text" class="input-phone" name="number" placeholder="{{$room->phoneOfManager}}">
                        <button class="btn btn-default btn-block btn-main-3"style="float:right;padding-top:0px;">确认</button>
                        </div>
                    </div>
                    
                </form>
                </div>
            </div>
            <hr class="mysplit">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    白日房管理
                </div>
                <div><span>时间</span><input type="text" class="input-phone" name="title" placeholder="{{$room->title}}"><br>
                    <span>时长</span><input type="text"  class="input-phone" name="title" placeholder="{{$room->title}}">
<button class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;">使用</button>
                </div>
                
            </div>
            <hr class="mysplit">
            <div class="mybox" style="box-shadow:none;">
                <div class="b-color font-xl">
                    夜晚管理
                </div>
                <div><span>日期</span><input type="text"  class="input-phone" name="title" placeholder="{{$room->title}}">
                    <button class="btn btn-default btn-block btn-main-3" style="float:right;padding-top:0px;">使用</button>
                </div>
                
            </div>
        </div>
        @endforeach
    </div>

@endsection
