<style type="text/css">
	body{text-align: center;}
	form{margin-top: 100px;}
	input{margin-top: 15px;}
	button{margin-left: 140px;}
</style>
<body>
	<form>
		<input type='hidden' name='id' value="<?php echo $user['id']?>">
		姓名：<input type="text" name="name" value="<?php echo $user['name']?>"></br>
		年龄：<input type="text" name="age" value="<?php echo $user['age']?>"></br>
		
	</form>
	<button onclick='save()'>保存</button>
</body>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
	function save()
	{
		var name = $.trim($('input[name=name]').val());
		if (name == '') {
			alert('请输入姓名');
			return;
		}
		$.post('/users/save', $('form').serialize(), function(res){
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