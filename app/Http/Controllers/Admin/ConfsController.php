<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ConfsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfsController extends Controller
{
    /**
     * get   admin/confs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConfsModel::orderBy('conf_order','desc')->paginate(4);
        foreach($data as $k=>$v){
            switch ($v->field_type){
                case  'input':
                    $data[$k]->_html='<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'"/>';
                    break;
                case  'textarea':
                    $data[$k]->_html='<textarea type="text" class="lg" name="conf_content[]" />'.$v->conf_content.'</textarea>';
                    break;
                case  'radio':
                    //1|开启, 0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        $r = explode('|',$n);
                        $c = '';
                        if($v->conf_content == $r[0]){
                            $c = ' checked ';
                        }
                        $str.='<input type="radio" name="conf_content[]" '.$c.' value="'.$r[0].'">'.$r[1].'　';
                    }
                    $data[$k]->_html=$str;
                    break;
            }

        }
        return view('admin.confs.list',compact('data'));
    }

    public function changeContent(){
        $input = Input::except('_token');
        foreach($input['conf_id'] as $k=>$v){
            ConfsModel::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        return back()->with('msg','配置项更新成功');
    }

//    public function putm(){
//        $config = ConfsModel::pluck('conf_content','conf_name');
//        dd($config);
//        var_export($config,true);
//        $path = base_path().'\config\web.php';
//        $str = '<?php '.var_export($config,true).';';
//        file_put_contents($path,$str);
//    }

    public function changeorder(){
        $input = Input::except('_token');
        $fiels = ConfsModel::find($input['conf_id']);
        $fiels->conf_order = $input['conf_order'];
        $re = $fiels->update();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'配置项修改成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'配置项修改失败!'
            ];
        }
        return $data;
    }

    /**
     * get  admin/confs/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.confs.add');
    }

    /**
     * post admin/confs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name'=>'required|max:10|unique:confs',
            'conf_title'=>'required|max:20|unique:confs',
        ];
        $messages = [
            'conf_name.required'=>'配置项名称不能为空!',
            'conf_name.max'=>'配置项名称最多10个字!',
            'conf_name.unique'=>'配置项名称已存在!',
            'conf_title.unique'=>'配置项标题已存在!',
            'conf_title.required'=>'配置项标题不能为空!',
            'conf_title.max'=>'配置项标题最多20个字!',
        ];
        $validator = Validator::make($input,$rules,$messages);;
        if($validator->passes()){
            $re = ConfsModel::create($input);
            if($re){
                return redirect('admin/confs');
            }else{
                return back()->with('errors','配置项信息添加失败!');
            }
        }else{
            return back()->withErrors($validator);
        }
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
     * get  admin/confs/{confs}/edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($conf_id)
    {
        $field = ConfsModel::find($conf_id);
        return view('admin.confs.edit',compact('field'));
    }

    /**
     * put  admin/confs/{confs}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $conf_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'conf_name'=>'required|max:10',
            'conf_title'=>'required|max:20',
            'conf_order'=>'required',
        ];
        $messages = [
            'conf_name.required'=>'配置项名称不能为空!',
            'conf_name.max'=>'配置项名称最多10个字!',
            'conf_title.required'=>'配置项标题不能为空!',
            'conf_title.max'=>'配置项标题最多20个字!',
            'conf_order.required'=>'配置项排序不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = ConfsModel::where('conf_id',$conf_id)->update($input);
            if($re){
//                $this->putm();
                return redirect('admin/confs');
            }else{
                return back()->with('msg','无任何修改!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * delete  admin/confs/{confs}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($conf_id)
    {
        $re = ConfsModel::where('conf_id',$conf_id)->delete();
        if($re){
//            $this->putm();
            $data = [
                'status'=>1,
                'msg'=>'配置项删除成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'配置项删除失败!'
            ];
        }
        return $data;
    }
}
