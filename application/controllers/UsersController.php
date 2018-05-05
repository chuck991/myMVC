<?php

class UsersController extends Controller
{
	public function index()
	{
		$users = new Model;
		$rsts = $users->table('users')->selectAll();
		$this->assign('users', $rsts);
		return $this->fetch();
	}
	public function add($uid=null)
	{
		$users = new Model;
		$user = $users->table('users')->select($uid);
		$this->assign('user', $user);
		return $this->fetch();
	}
	public function save()
	{
		$data['id'] = (int)$_POST['id'];
		$data['name'] = trim($_POST['name']);
		$data['age'] = (int)$_POST['age'];

		if ($data['name'] == '') {
			exit(json_encode(array("code"=>1, "msg"=>'姓名不能为空')));
		}

		$users = new Model;
		if ($data['id'] == 0) {
			//新增
			$rst = $users->table('users')->insert($data);
			if (!$rst) {
				exit(json_encode(array("code"=>1, "msg"=>'保存失败')));
			}
		} else {
			$users->table('users')->update($data['id'], $data);
		}
		exit(json_encode(array("code"=>0, "msg"=>'保存成功')));
	}
	public function del()
	{
		$id = (int)$_POST['id'];
		$user = new Model;
		$rst = $user->table('users')->delete($id);
		if ($rst) {
			exit(json_encode(array("code"=>0, "msg"=>'删除成功')));
		}
		exit(json_encode(array("code"=>1, "msg"=>'删除失败')));
	}
}