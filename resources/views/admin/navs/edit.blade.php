@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加自定义导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集别名与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_alias">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加自定义导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>自定义导航列表</a>
            </div>
        </div>
    </div>
    <!--结果集别名与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs/'.$field->nav_id)}}" method="post">
            <input name="_method" value="put" type="hidden"/>
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" class="sm" name="nav_name" value="{{$field->nav_name}}">
                            @if ($errors->has('nav_name'))
                                <p class="text-warning"> {{$errors->first('nav_name')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>导航别名：</th>
                        <td>
                            <input type="text" class="lg" name="nav_alias" value="{{$field->nav_alias}}">
                            @if ($errors->has('nav_alias'))
                                <p class="text-warning"> {{$errors->first('nav_alias')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>导航url：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                            @if ($errors->has('nav_url'))
                                <p class="text-warning"> {{$errors->first('nav_url')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>导航排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="{{$field->nav_order}}">
                            @if ($errors->has('nav_order'))
                                <p class="text-warning"> {{$errors->first('nav_order')}}</p>
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