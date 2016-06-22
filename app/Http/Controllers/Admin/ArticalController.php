<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Artical;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticalController extends Controller
{
    /**
     * get   admin/artical.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Artical::paginate(3);
        return view('admin.artical.index',compact('data'));
    }

    /**
     * get  admin/artical/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.artical.add',compact('data'));
    }
    /**
     * post admin/artical.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'cate_id'=>'required',
            'art_tag'=>'required|unique:Artical|max:6',
            'art_title'=>'required|unique:Artical|max:30',
            'art_description'=>'required|max:200',
            'art_thumb'=>'required',
            'art_content'=>'required|max:2000',
            'art_editor'=>'required',
        ];
        $messages = [
            'cate_id.required'=>'文章分类不能为空!',
            'art_tag.required'=>'文章标签不能为空!',
            'art_tag.unique'=>'文章标签已存在!',
            'art_tag.max'=>'文章标签不要超过6个字哦!',
            'art_title.required'=>'文章标题不能为空!',
            'art_title.unique'=>'文章标题已存在!',
            'art_title.max'=>'文章标题不要超过30个字哦!',
            'art_description.required'=>'文章描述不能为空!',
            'art_description.max'=>'文章描述不要超过200个字哦!',
            'art_thumb.required'=>'文章缩略图不能为空!',
            'art_content.required'=>'文章内容不能为空!',
            'art_content.max'=>'文章内容不要超过2000个字哦!',
            'art_editor.required'=>'文章作者不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = Artical::create($input);
            if($re){
                return redirect('admin/artical');
            }else{
                return back()->with('errors','文章信息添加失败!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }


    /**
     * get  admin/artical/{artical}/edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Artical::find($art_id);
        return view('admin.artical.edit',compact('data','field'));
    }

    /**
     * put  admin/artical/{artical}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $art_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'cate_id'=>'required',
            'art_tag'=>'required|unique:Artical|max:6',
            'art_title'=>'required|unique:Artical|max:30',
            'art_description'=>'required|max:200',
            'art_thumb'=>'required',
            'art_content'=>'required|max:2000',
            'art_editor'=>'required',
        ];
        $messages = [
            'cate_id.required'=>'文章分类不能为空!',
            'art_tag.required'=>'文章标签不能为空!',
            'art_tag.unique'=>'文章标签已存在!',
            'art_tag.max'=>'文章标签不要超过6个字哦!',
            'art_title.required'=>'文章标题不能为空!',
            'art_title.unique'=>'文章标题已存在!',
            'art_title.max'=>'文章标题不要超过30个字哦!',
            'art_description.required'=>'文章描述不能为空!',
            'art_description.max'=>'文章描述不要超过200个字哦!',
            'art_thumb.required'=>'文章缩略图不能为空!',
            'art_content.required'=>'文章内容不能为空!',
            'art_content.max'=>'文章内容不要超过2000个字哦!',
            'art_editor.required'=>'文章作者不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = Artical::where('art_id',$art_id)->update($input);
            if($re){
                return redirect('admin/artical');
            }else{
                return back()->with('msg','文章信息更新失败!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * get  admin/artical/{artical}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * delete  admin/artical/{artical}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($art_id)
    {
       $re = Artical::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'该篇文章删除成功!',
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'该篇文章删除失败!',
            ];
        }
        return $data;
    }
}
