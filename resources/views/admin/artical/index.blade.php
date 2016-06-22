@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->

    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 文章列表
    </div>
    <!--面包屑导航 结束-->

	{{--<!--结果页快捷搜索框 开始-->--}}
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">

        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/artical/create')}}"><i class="fa fa-plus"></i>文章添加</a>
                    <a href="{{url('admin/artical')}}"><i class="fa fa-recycle"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">ID</th>
                        <th>文章标题</th>
                        <th>作者</th>
                        <th>查看次数</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $d)
                    <tr>
                        <th class="tc" width="5%">{{$d->art_id}}</th>
                        <th><a href="">{{$d->art_title}}</a></th>
                        <th>{{$d->art_editor}}</th>
                        <th>{{$d->art_view}}</th>
                        <th>{{date('Y年m月d日', $d->art_time)}}</th>
                        <th><a href="{{url('admin/artical/'.$d->art_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delArt({{$d->art_id}});">删除</a></th>
                    </tr>
                        @endforeach
                </table>
                <div class="page_list">
                    {!!$data->render()!!}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
    <script>

            function delArt(art_id){
                layer.confirm('您确定要删除这个文章吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post('{{url('admin/artical/')}}/'+art_id,{'_method':'delete','_token':'{{csrf_token()}}','art_id':art_id},function(data){
                        if(data.status == 1){
                            location.href = location.href;
                            layer.msg(data.msg, {icon: 6});
                        }else{
                            location.href = location.href;
                            layer.msg(data.msg, {icon: 5});
                        }
                    });
//                layer.msg('的确很重要', {icon: 1});
                }, function(){
//                layer.msg('也可以这样', {
//                    time: 20000, //20s后自动关闭
//                    btn: ['明白了', '知道了']
//                });
                });
            }

    </script>


@endsection