@extends('layout.app')
@section('scripts')   
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('onMenuShareQQ', 'onMenuShareWeibo','openLocation','getLocation'), true) ?>);
    
    wx.ready(function(){
    console.log('成功调用');
    document.querySelector('#openLocation').onclick = function () {
      wx.openLocation({
        latitude: 38.099994,
        longitude: 115.324520,
        name: 'hi',
        address: '123',
        scale: 14,
        infoUrl: 'http://weixin.qq.com'
      });
    };

    document.querySelector('#getLocation').onclick = function () {
      wx.getLocation({
        success: function (res) {
          alert(JSON.stringify(res));
        },
        cancel: function (res) {
          alert('用户拒绝');
        }
      });
    };
  });

  wx.error(function(res){
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        console.log(res);
    });
</script>
@endsection
@section('content')
  <h3>地理位置接口</h3>
      <span>使用微信内置地图查看位置接口</span>
      <button class="btn btn_primary" id="openLocation">openLocation</button>
      <span>获取地理位置接口</span>
      <button class="btn btn_primary" id="getLocation">getLocation</button>
@endsection
