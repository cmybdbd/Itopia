@extends('layout.app')
@section('style')
    <style>
        form span{
            display: inline-block;
            width: 6em;
        }
    </style>
@endsection

@section('content')
    <ul class="nav nav-pills" role="tablist" style="display:flex;justify-content: space-between">
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
            <div>
                <form action="{{url('/manage/room')}}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$room->id}}">
                    <div><span>房间号:</span><input type="text" name="title" placeholder="{{$room->title}}"></div>
                    <div><span>地址:</span><input type="text" name="address" placeholder="{{$room->address}}"></div>
                    <div><span>时租:</span><input type="number" name="hourPrice" placeholder="{{$room->hourPrice}}" ></div>
                    <div><span>整租:</span><input type="number" name="nightPrice" placeholder="{{$room->nightPrice}}"></div>
                    <div><span>管理手机号:</span><input type="number" name="number" placeholder="{{$room->phoneOfManager}}"></div>
                    <button class="btn btn-default btn-block">确认</button>
                </form>
            </div>

        </div>
        @endforeach
    </div>
@endsection
