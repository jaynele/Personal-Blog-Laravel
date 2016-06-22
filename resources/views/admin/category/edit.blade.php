@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 修改分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>分类列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/category/'.$field->cate_id)}}" method="post">
            <input name="_method" value="put" type="hidden"/>
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="">==顶级分类==</option>
                                @foreach($data as $d)
                                <option value="{{$d->cate_id}}"
                                        @if($d->cate_id == $field->cate_pid)
                                            selected
                                        @endif
                                >{{$d->cate_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cate_pid'))
                                <p style="color:red"> {{$errors->first('cate_pid')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text" class="sm" name="cate_name" value="{{$field->cate_name}}">
                            @if ($errors->has('cate_name'))
                                <p style="color:red"> {{$errors->first('cate_name')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类标题：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title" value="{{$field->cate_title}}">
                            @if ($errors->has('cate_title'))
                                <p style="color:red"> {{$errors->first('cate_title')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>关键字：</th>
                        <td>
                            <textarea name="cate_keywords">{{$field->cate_keywords}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea class="lg" name="cate_dicription">{{$field->cate_dicription}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类排序：</th>
                        <td>
                            <input type="text" class="sm" name="cate_order" value="{{$field->cate_order}}">
                            @if ($errors->has('cate_order'))
                                <p style="color:red"> {{$errors->first('cate_order')}}</p>
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
                    <tr>
                        <th></th>
                        <td>
                            @if(session('msg'))
                                <p style="color:red">{{session('msg')}}</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

    </div>

@endsection