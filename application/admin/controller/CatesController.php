<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Cate;

class CatesController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
              
        $cates = Cate::getOrderCates();
        return view('cate/index', ['cates'=>$cates]);

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($id)
    {

        $cates = Cate::getOrderCates();

        return view('cate/create', ['cates'=>$cates, 'id'=>$id]);  
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $req)
    {
        $formData = $req->post(null,null,'trim');

        try{
            Cate::create($formData, ['pid','cname']);
        }catch(\Exception $e){
            return $this->error('添加类别失败!', '/cate/create');
        }
        return $this->success('添加类别成功!', '/cate/create');

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $cate = Cate::get($id);
        return view('cate/edit', ['cate'=>$cate]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $req, $id)
    {
        $formData = $req->post(null,null,'trim');

        try{
            Cate::update($formData, ['cid'=>$id], ['cname']);
        }catch(\Exception $e){
            return $this->error('类别名称修改失败~', '/cate/edit/'.$id);
        }
        return $this->success('类别名称修改成功', '/cate/index');

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {

        // 要删除的类别是否有子类
        $cate = Cate::where('pid', '=', $id)->find();

        if ( $cate ) {
            return $this->error('该分类下面有子分类,所有不能删除', '/cate/index');
        }

        // 是否该分类下有具体的商品

        $row = Cate::destroy($id);
        if ( $row ) {
            return $this->success('删除成功!', '/cate/index');
        }
        return $this->error('删除失败!', '/cate/index');
    }
}
