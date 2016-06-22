@extends('layouts.admin')
@section('content')
    <!--面包屑网站配置 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加网站配置
    </div>
    <!--面包屑网站配置 结束-->

	<!--结果集别名与网站配置组件 开始-->
	<div class="result_wrap">
        <div class="result_alias">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/confs/create')}}"><i class="fa fa-plus"></i>添加网站配置</a>
                <a href="{{url('admin/confs')}}"><i class="fa fa-recycle"></i>网站配置列表</a>
            </div>
        </div>
    </div>
    <!--结果集别名与网站配置组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/confs/'.$field->conf_id)}}" method="post">
            {{--<input name="_method" value="put" type="hidden"/>--}}
            {{method_field('PUT')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>网站配置标题：</th>
                        <td>
                            <input type="text" class="sm" name="conf_title" value="{{$field->conf_title}}">
                            @if ($errors->has('conf_title'))
                                <p class="text-warning"> {{$errors->first('conf_title')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>网站配置名称：</th>
                        <td>
                            <input type="text" class="sm" name="conf_name" value="{{$field->conf_name}}">
                            @if ($errors->has('conf_name'))
                                <p class="text-warning"> {{$errors->first('conf_name')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>网站配置类型：</th>
                        <td>
                            <input type="radio" name="field_type" checked value="input" @if($field->field_type == 'input')checked @endif onclick="getT();"/>input
                            <input type="radio" name="field_type" value="textarea" @if($field->field_type == 'textarea')checked @endif onclick="getT();"/>textarea
                            <input type="radio" name="field_type" value="radio" @if($field->field_type == 'radio')checked @endif onclick="getT();"/>radio
                            @if ($errors->has('field_type'))
                                <p class="text-warning"> {{$errors->first('field_type')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr  id="field_value">
                        <th><i class="require">*</i>网站配置类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value" value="{{$field->field_value}}"><p>类型值只有在radio的情况下才需要配置,格式 1|开启, 0|关闭</p>
                            @if ($errors->has('field_value'))
                                <p class="text-warning"> {{$errors->first('field_value')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>网站配置排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{$field->conf_order}}">
                            @if ($errors->has('conf_order'))
                                <p class="text-warning"> {{$errors->first('conf_order')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>网站配置说明：</th>
                        <td>
                            <textarea name="conf_tips" id="" cols="30" rows="10" >{{$field->conf_tips}}</textarea>
                            @if ($errors->has('conf_tips'))
                                <p class="text-warning"> {{$errors->first('conf_tips')}}</p>
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
            <p style="color:red">{{session('msg')}}</p>
        @endif
    </div>
    <script>
        getT();
        function getT(){
            var field_value = $('input[name=field_type]:checked').val();
            if(field_value == 'radio'){
                $('#field_value').show();
            }else{
                $('#field_value').hide();
            }
        }
    </script>

@endsection