@extends('layout.app')
@section('content')
    <div style="margin: 2vh">
        <div >
            @foreach($orders as $key => $order)
                <div id="{{$order->id}}" roomId="{{$order->roomId}}"
                     type="{{$order->isDay? 'day':'night'}}"
                     class="order">
                    <div>
                        <span>房间：</span><span>{{$order->hasRoom->title}}</span>
                        <span>结束时间：</span><span id="endTime">{{$order->endTime}}</span>
                    </div>
                    <div>
                        <button class="btn btn-block btn-default conf m-color">确认</button>
                    </div>
                    <hr class="mysplit-color" style="margin: 2vh 0">
                </div>

            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(".conf").click(function(){
            console.log($(this).parent().parent().attr("id"));
            btn = $(this);
            $.ajax(
                {
                    type: "POST",
                    data :{
                        _token: $("meta[name='csrf-token']").attr('content'),
                        oid:$(this).parent().parent().attr("id")
                    },
                    success: function(e){
                        btn.removeClass('m-color');
                        btn.addClass('u-color');
                    }
                }
            )

        })
    </script>
@endsection