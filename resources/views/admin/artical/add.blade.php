@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/artical/create')}}"><i class="fa fa-plus"></i>文章添加</a>
                <a href="{{url('admin/artical')}}"><i class="fa fa-recycle"></i>文章列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/artical')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($data as $d)
                                <option value="{{$d->cate_id}}"><?php echo str_repeat("&nbsp;",$d->lev*3)?>{{$d->cate_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cate_id'))
                                <p class="text-warning"> {{$errors->first('cate_id')}}</p>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                            @if ($errors->has('art_title'))
                                <p class="text-warning"> {{$errors->first('art_title')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章作者：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor">
                            @if ($errors->has('art_editor'))
                                <p class="text-warning"> {{$errors->first('art_editor')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {
                                    $('#file_upload').uploadify({
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'     : "{{csrf_token()}}"
                                        },
                                        'buttonText' : 'BROWSE...',
                                        'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{url('admin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src','/'+data);
                                        }
                                    });
                                });
                            </script>
                            @if ($errors->has('art_thumb'))
                                <p class="text-warning"> {{$errors->first('art_thumb')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="" id="art_thumb_img" style="max-width: 300px;max-height: 200px;" alt=""/>
                        </td>
                    </tr>
                    <tr>
                        <th>关键字：</th>
                        <td>
                            <input type="text"  size="50" name="art_tag">
                            @if ($errors->has('art_tag'))
                                <p class="text-warning"> {{$errors->first('art_tag')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea class="lg" name="art_description"></textarea>
                            @if ($errors->has('art_description'))
                                <p class="text-warning"> {{$errors->first('art_description')}}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" type="text/plain" name="art_content" style="width:800px;height:200px;"></script>
                            <script type="text/javascript">
                                var ue = UE.getEditor('editor');
                            </script>
                            @if ($errors->has('art_content'))
                                <p class="text-warning"> {{$errors->first('art_content')}}</p>
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

@endsection