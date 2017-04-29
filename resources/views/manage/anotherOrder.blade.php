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
                    </div>
                    <div>
                            <span>结束时间：</span><span id="endTime">{{date('H:i:s',strtotime($order->endTime))}}</span>
                            <span>{{$order->state == \App\Utils\Constant::$ORDER_STATE['COMPLETE']? '已结束':($order->state == \App\Utils\Constant::$ORDER_STATE['HISTORY']?'已打扫':'')}}</span>
                        @if($order->state == \App\Utils\Constant::$ORDER_STATE['COMPLETE'])
                            <button class="btn btn-default conf m-color">确认</button>
                        @endif
                    </div>
                    <hr class="mysplit-color" style="margin: 2vh 0">
                </div>

            @endforeach
        </div>
    </div>



    <div class="modal fade bs-example-modal-sm confirm-content" role="dialog" style="">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div style="width: 70vw">
                        <div>
                            <div style="text-align:center">
                                <p>是否确认打扫完毕？</p>
                            </div>
                            <hr class="mysplit">
                            <div class="btn-group" style="width: 100%">
                                <button class="btn btn-block btn-default m-color" style="" data-dismiss="modal">否</button>
                                <button class="btn btn-block btn-default m-color" style="" id="confirmFinish">是</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        $(".conf").click(function(){
            //console.log($(this).parent().parent().attr("id"));
            btn = $(this);
            $(".confirm-content").modal()
                .one('click', '#confirmFinish', function(e){
                    $.ajax(
                        {
                            type: "POST",
                            data :{
                                _token: $("meta[name='csrf-token']").attr('content'),
                                oid: btn.parent().parent().attr("id")
                            },
                            success: function(e){
                                btn.removeClass('m-color');
                                btn.addClass('u-color');
                                $(".confirm-content").modal('hide');
                            }
                        }
                    );
                })

        })
    </script>
@endsection