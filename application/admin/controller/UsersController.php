<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\User;

class UsersController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $req)
    {
        // dump( $req->get('uname') ); // 没有传值,返回NULL   有传值,无内容 返回空字符串

        // 1.拿数据
        $condition = [];

        // 是否有性别条件
        if ( $sex = $req->get('sex') ) {
            $condition[] = ['sex', '=', $sex]; // sex=m
        }

        // 是否有姓名条件
        if ( $uname = $req->get('uname') ) {
            $condition[] = ['uname', 'like', "%$uname%"];
        }

        $users = User::where( $condition ) -> paginate(3) -> appends( $req->get() );

        // 生成页码字符串
        $page_string = $users->render();

        
      
        // dump($users);
        

        // 2.显示模板
        return view('user/index', ['users' => $users, 'page_string' => $page_string]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
       return view('user/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $formData = $request->post(null,null,'trim');
     
        if (empty($formData['upwd']) || empty($formData['reupwd']) ) {
            return $this->error('密码不能为空~', '/user-create');
        }

        if ($formData['upwd']!=$formData['reupwd']) {
            return $this->error('两次密码不一致!', '/user-create');
        }

        $formData['upwd'] = md5($formData['upwd']);
        $formData['regtime'] = time();


        try{
           User::create($formData, ['auth','uname','upwd','sex','tel','regtime']);
        }catch(\think\exception\PDOException $e){
           return $this->error('添加用户失败', '/user-create');
        }
        return $this->success('添加用户成功', '/user-create', null, 2);
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
        $user = User::get($id);
        return view('user/edit', ['user' => $user]);
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
            // 参数说明: 1)更新的数据  2)条件     3)允许修改的字段
            User::update($formData, ['uid'=>$id], ['auth','uname','sex','tel']);
        }catch(\think\exception\PDOException $e){
            return $this->error('修改用户信息失败', '/user-edit/'.$id);
        }
        return $this->success('修改完成', '/user-index');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $row = User::destroy($id); // 返回受影响行数

        if ( $row ) {
           return $this->success('删除用户成功', '/user-index');
        }
        return $this->error('删除用户失败', '/user-index');
    }
}
