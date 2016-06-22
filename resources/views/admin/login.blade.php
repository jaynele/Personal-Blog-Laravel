@extends('layouts.admin')
@section('content')
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
            @if(session('msg'))
			<p style="color:red">{{session('msg')}}</p>
            @endif
			<form action="#" method="post" id="formLjl">
                {{csrf_field()}}
				<ul>
					<li>
					<input type="text" name="user_name" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="user_pass"  class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
                    <li>
                        <input type="text" name="user_mobile" id="mobile" class="text"/>
                        <span><i class="fa fa-fax" aria-hidden="true"></i></span>
                    </li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</li>
                    <li>
                        <input type="text" name="user_code" id="user_code" placeholder="输入验证码" class="text"/>
                        <span><i class="fa fa-fax" aria-hidden="true"></i></span>
                        {{--<a href="javascript:;" onclick="sms();"><label for="">点击获取短信验证码</label></a>--}}
                        <div class="btn-group">
                        <button onclick="sms(this);" class="btn">点击获取短信验证码 </button>
                        </div>
                    </li>
					<li>
						<input type="submit" id="sub" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.hou.com" target="_blank">http://www.hou.com</a></p>
		</div>
	</div>
    <script>
        {{--$('#formLjl').submit(function () {--}}
            {{--var smscode;--}}
            {{--$.ajax('{{url('/admin/sms')}}',{--}}
                {{--'async':false,--}}
                {{--'success':function(msg){--}}
                    {{--alert(msg);--}}
                    {{--smscode = msg;--}}
                {{--}--}}
            {{--});--}}
            {{--if(smscode != $('#user_code').val()){--}}
                {{--alert('短信验证码不对');--}}
                {{--return false;--}}
            {{--};--}}

        {{--});--}}

        function sms(obj){
            var mobile = $('#mobile').val();
            if(!/^1[3578]\d{9}$/.test(mobile)){
                alert('手机号不正确');
                return false;
            }
            var btn = obj;
            btn.disabled = true;
            var timer = 60;
            var clock = null;
            clock = setInterval(function(){
                --timer;
                if(timer > 0){
                    btn.innerHTML = timer + '秒后可重新获取短信验证码';
                }else{
                    btn.disable = false;
                    btn.innerHTML =  '点击重新获取短信验证码';
                }
            },1000);
            $.get('/admin/sms/'+mobile,function(data){
                console.log(data);
            });
            return false;
        }


    </script>
@endsection