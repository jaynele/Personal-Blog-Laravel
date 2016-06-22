@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加友情链接
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>友情链接列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/links/'.$field->link_id)}}" method="post">
            <input name="_method" value="put" type="hidden"/>
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" class="sm" name="link_name" value="{{$field->link_name}}">
                            @if ($errors->has('link_name'))
                                <p class="text-warning"> {{$errors->first('link_name')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title" value="{{$field->link_title}}">
                            @if ($errors->has('link_title'))
                                <p class="text-warning"> {{$errors->first('link_title')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接url：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="{{$field->link_url}}">
                            @if ($errors->has('link_url'))
                                <p class="text-warning"> {{$errors->first('link_url')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order" value="{{$field->link_order}}">
                            @if ($errors->has('link_order'))
                                <p class="text-warning"> {{$errors->first('link_order')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>

            @if(session('msg'))
                <p style="color:red;margin-left: 253px;" >{{session('msg')}}</p>
            @endif


    </div>

@endsection