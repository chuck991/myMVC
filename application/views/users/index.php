<style type="text/css">
	table{text-align: center;margin:100px auto ;border-collapse: collapse;width: 500px;}
	td{border:1px solid;height: 50px;}
	button{position: absolute;top:70px;left:970px;}
</style>
<body>
	<button onclick='add()'>添加</button>
	<table>
		<tr>
			<td>id</td>
			<td>姓名</td>
			<td>年龄</td>
			<td>操作</td>
		</tr>

	 <?php foreach($users as $user): ?>
		<tr>
			<td><?php echo $user['id']?></td>
			<td><?php echo $user['name']?></td>
			<td><?php echo $user['age']?></td>
			<td>
				<input type="button" onclick="add(<?php echo $user['id']?>);return false;" value="编辑">
				<input type="button" onclick="javascript: if (confirm('确定要删除吗')){del(<?php echo $user['id']?>);}return false;" value="删除">
			</td>
		</tr>
	<?php endforeach;?>
	</table>
</body>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
	function add(id)
	{
		var url = '';
		if (id > 0) {
			url = '/'+id;
		}
		window.location.href = '/users/add' + url;
	}
	function del(id)
	{
		$.post('/users/del', {'id': id}, function(res){
			if (res.code > 0) {
				alert(res.msg);
				return;
			}
			alert(res.msg);
			setTimeout(function(){
				window.location.href = '/users/index';
			}, 1000);
		}, 'json');
	}
</script>