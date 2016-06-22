@extends('layouts.admin')
@section('content')
    <!--面包屑网站配置 开始-->

    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 网站配置列表
    </div>
    <!--面包屑网站配置 结束-->

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

        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷网站配置 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/confs/create')}}"><i class="fa fa-plus"></i>添加网站配置</a>
                    <a href="{{url('admin/confs')}}"><i class="fa fa-recycle"></i>网站配置列表</a>
                </div>
            </div>
            <!--快捷网站配置 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/confs/changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">网站配置排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>网站配置标题</th>
                        <th>网站配置名称</th>
                        <th>网站配置内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $c)
                    <tr>
                        <td class="tc">
                            <input type="text"  onchange="changeOrder(this,{{$c->conf_id}});" value="{{$c->conf_order}}">
                        </td>
                        <td class="tc">{{$c->conf_id}}</td>
                        <td>
                            <a href="#">{{$c->conf_title}}</a>
                        </td>
                        <td>
                            <a href="#">{{$c->conf_name}}</a>
                        </td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$c->conf_id}}" />
                            <a href="#">{!!$c->_html!!}</a>
                        </td>
                        <td>
                            <a href="{{url('admin/confs/'.$c->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delconfs({{$c->conf_id}});">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <p>
                            @if(session('msg'))
                                 <p style="color:red">{{session('msg')}}</p>
                              @endif
                    </tr>
                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>
                    </form>
                <div class="page_list">
                    {!!$data->render()!!}
                </div>
            </div>
        </div>



    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
    <script>
        function changeOrder(obj,conf_id){
            var conf_order = $(obj).val();
            $.post('{{url('admin/confs/changeorder')}}',{'_token':'{{csrf_token()}}','conf_order':conf_order,'conf_id':conf_id},function(data){
                    if(data.status == 1){
                        layer.alert(data.msg, {icon: 6});
                        location.href = location.href;
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        location.href = location.href;
                    }
            })

        }
        //delete the cate
        function delconfs(conf_id){
            layer.confirm('您确定要删除这个网站配置吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/confs/')}}/'+conf_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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