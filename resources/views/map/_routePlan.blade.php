@extends('layout.app')

@section('style')
    <style>
        .equipment-content img{
            width: 2em;
        }
        .equipment-content div.center{
            padding-left: 0.7em;
        }
        .equipment-content p {
            font-size: 0.8em;
            display: inline-block;

            line-height: 1.2em;
            padding: 0.4em 0em;
            margin:0  0.25em;
            width: 45%;
        }
        .equipment-content p > img{
            margin-right: 0.4em;
        }
        .equipment-content p > span{
            text-align: center;
        }
        span.item{
            width: 15em;
        }
        span.room-state{
            height: 1.6em;
        }

        .e{
            background-image: -webkit-linear-gradient( top,#fff,transparent);
            -moz-background-image: -moz-linear-gradient( top,#fff,transparent);
           opacity:0.5;
        }

        .blend
        {
            overflow: hidden;
            background-size:1068px;
            background-image: url({{asset('storage/map/mapPKU.png')}}), -webkit-linear-gradient( top,#aaa,#000);
            -moz-background-image: url({{asset('storage/map/mapPKU.png')}}), -moz-linear-gradient( top,#aaa,#000);
            background-blend-mode: screen;
        }
*{
    margin:0px;
    padding:0px;
}
body, button, input, select, textarea {
    font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
}
#container{
    min-width:300px;
    min-height:765px;
}
    </style>
@endsection
@section('scripts')
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script>
    var map, 
        directionsService = new qq.maps.DrivingService({
            complete : function(response){
                var start = response.detail.start,
                    end = response.detail.end;
                
                var anchor = new qq.maps.Point(6, 6),
                    size = new qq.maps.Size(24, 36),
                    start_icon = new qq.maps.MarkerImage(
                        'img/busmarker.png', 
                        size, 
                        new qq.maps.Point(0, 0),
                        anchor
                    ),
                    end_icon = new qq.maps.MarkerImage(
                        'img/busmarker.png', 
                        size, 
                        new qq.maps.Point(24, 0),
                        anchor
                        
                    );
                start_marker && start_marker.setMap(null); 
                end_marker && end_marker.setMap(null);
                clearOverlay(route_lines);
                
                start_marker = new qq.maps.Marker({
                      icon: start_icon,
                      position: start.latLng,
                      map: map,
                      zIndex:1
                });
                end_marker = new qq.maps.Marker({
                      icon: end_icon,
                      position: end.latLng,
                      map: map,
                      zIndex:1
                });
               directions_routes = response.detail.routes;
               var routes_desc=[];
               //所有可选路线方案
               for(var i = 0;i < directions_routes.length; i++){
                    var route = directions_routes[i],
                        legs = route; 
                    //调整地图窗口显示所有路线    
                    map.fitBounds(response.detail.bounds); 
                    //所有路程信息            
                    //for(var j = 0 ; j < legs.length; j++){
                        var steps = legs.steps;
                        route_steps = steps;
                        polyline = new qq.maps.Polyline(
                            {
                                path: route.path,
                                strokeColor: '#3893F9',
                                strokeWeight: 6,
                                map: map
                            }
                        )  
                        route_lines.push(polyline);
                         //所有路段信息
                        for(var k = 0; k < steps.length; k++){
                            var step = steps[k];
                            //路段途经地标
                            directions_placemarks.push(step.placemarks);
                            //转向
                            var turning  = step.turning,
                                img_position;; 
                            switch(turning.text){
                                case '左转':
                                    img_position = '0px 0px'  
                                break;
                                case '右转':
                                    img_position = '-19px 0px'  
                                break;
                                case '直行':
                                    img_position = '-38px 0px'  
                                break;  
                                case '偏左转':
                                case '靠左':
                                    img_position = '-57px 0px'  
                                break;      
                                case '偏右转':
                                case '靠右':
                                    img_position = '-76px 0px'  
                                break;
                                case '左转调头':
                                    img_position = '-95px 0px'  
                                break;
                                default:
                                    mg_position = ''  
                                break;
                            }
                            var turning_img = '&nbsp;&nbsp;<span'+
                                ' style="margin-bottom: -4px;'+
                                'display:inline-block;background:'+
                                'url(img/turning.png) no-repeat '+
                                img_position+';width:19px;height:'+
                                '19px"></span>&nbsp;' ;
                            var p_attributes = [
                                'onclick="renderStep('+k+')"',
                                'onmouseover=this.style.background="#eee"',
                                'onmouseout=this.style.background="#fff"',
                                'style="margin:5px 0px;cursor:pointer"'
                            ].join(' ');
                            routes_desc.push('<p '+p_attributes+' ><b>'+(k+1)+
                            '.</b>'+turning_img+step.instructions);
                        }
                    //}
               }
            }
        }),
        directions_routes,
        directions_placemarks = [],
        directions_labels = [],
        start_marker,
        end_marker,
        route_lines = [],
        step_line,
        route_steps = [];

     $(document).ready(function(){
        map = new qq.maps.Map(document.getElementById("container"), {
            // 地图的中心地理坐标。
            center: new qq.maps.LatLng(39.993452,116.307197)
        });
        calcRoute();
    });
    function calcRoute() {
        var start_name = document.getElementById("start").value.split(",");
        var end_name = document.getElementById("end").value.split(",");
        var policy = document.getElementById("policy").value;
        route_steps = [];
            
        directionsService.setLocation("北京");
        directionsService.setPolicy(qq.maps.DrivingPolicy[policy]);
        directionsService.search(new qq.maps.LatLng(start_name[0], start_name[1]), 
            new qq.maps.LatLng(end_name[0], end_name[1]));
    }
    //清除地图上的marker
    function clearOverlay(overlays){
        var overlay;
        while(overlay = overlays.pop()){
            overlay.setMap(null);
        }
    }
    function renderStep(index){   
        var step = route_steps[index];
        //clear overlays;
        step_line && step_line.setMap(null);
        //draw setp line      
        step_line = new qq.maps.Polyline(
            {
                path: step.path,
                strokeColor: '#ff0000',
                strokeWeight: 6,
                map: map
            }
        )
    }
</script>
@endsection
@section('content')
    <div style='margin:5px 0px'>
        <b>起点: </b>
        <select id="start" onchange="calcRoute();">
          <option value="39.996017,116.386970">39.996017,116.386970</option>
        </select>
        <b>终点: </b>
        <select id="end" onchange="calcRoute();">
          <option value="39.910344,116.394095">39.910344,116.394095</option>
        </select>
        <b>计算策略：</b>
        <select id="policy" onchange="calcRoute();">
          <option value="LEAST_TIME">最少时间</option>
          <option value="LEAST_DISTANCE">最短距离</option>
          <option value="AVOID_HIGHWAYS">避开高速</option>
          <option value="REAL_TRAFFIC">实时路况</option>
          <option value="PREDICT_TRAFFIC">预测路况</option>
        </select>
    </div>
    <div id="container"></div>
    @endsection