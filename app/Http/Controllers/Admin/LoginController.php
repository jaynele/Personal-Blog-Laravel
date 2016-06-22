<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

require_once("resources/org/code/Code.class.php");
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if($_code != strtoupper($input['code'])){
                return back()->with('msg','请重新输入验证码!');
            }
            $user = User::first();
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass'] || $user->user_mobile != $input['user_mobile']){
                return back()->with('msg','请重新输入用户名,手机号或密码!');
            }else{
				$smscode = $this->checksms();
				if($smscode != $input['user_code']){
					return back()->with('msg','短信验证码不正确!');
				}else{
					session(['user'=>$user]);
					return redirect('admin/index');
				}
            }
        }else{
            return view('admin.login');
        }
    }

	public function sms(Request $request ,$mobile){
		include(base_path().'/resources/org/alidayu/TopSdk.php');
		$c = new \TopClient;
		$appkey = '23386140';
		$secret = '9feb6e4588c4f41f566b464363c22c8b';
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$rand = mt_rand(100000,999999);
		$request->session()->put('smscode',$rand);
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req->setExtend("123456");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("注册验证");
		$req->setRecNum($mobile);
		$req->setSmsParam("{\"code\":\"{$rand}\",\"product\":\"短信测试\"}");
		$req->setSmsTemplateCode("SMS_8270413");
//        print_r($req);
		$resp = $c->execute($req);
//        var_dump($resp);
	}

	public function checksms(){
		return session('smscode');
	}

    public function code(){
        $code = new \Code;
        return $code->make();
    }

    public function crypt(){
        $str = 123456;
        echo Crypt::encrypt($str);
        echo '<br />';
        echo Crypt::decrypt(Crypt::encrypt($str));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
