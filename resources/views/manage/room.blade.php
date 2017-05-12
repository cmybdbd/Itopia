@extends('layout.app')

@section('content')
    <ul class="nav nav-pills" role="tablist" style="display:flex;justify-content: space-between">
        @foreach($rooms as $key => $room)
        <li role="presentation" class="{{$key == 0 ? 'active':''}}">
            <a href="{{$room->title}}" aria-controls="{{$room->title}}" role="tab"
               data-toggle="pill">
                {{$room->title}}
            </a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($rooms as $key => $room)
        <div role="tabpanel" class="tab-pane {{$key == 0? 'active':''}}" id="{{$room->title}}">
            <div>
                <span>时租</span><span>{{$room->hourPrice}}</span>
                <span>整租</span><span>{{$room->nightPrice}}</span>
                <button class="btn btn-default">确认</button>
            </div>
            <div>
                <span>管理手机号</span><span>{{$room->phoneOfManager}}</span>
                <button class="btn btn-default">确认</button>
            </div>
        </div>
        @endforeach
    </div>
@endsection
