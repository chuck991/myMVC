<?php
/**
 *数据库操作
 */
class Sql
{
	protected $_dbHandle;
	protected $_result;
	public $_model;
	public $_table;

	function __construct()
	{
		//链接数据库
		$this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		//获取模型名称
		$this->model = get_class($this);

		$this->_model = rtrim($this->model, 'Model');
		//数据库表名与类名一致
		$this->_table = strtolower($this->_model);
	}

	public function table($table)
	{
		$this->_table = $table;
		return $this;
	}

	//链接数据库
	public function connect($host, $user, $pass, $dbname)
	{
		try {
			$dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);
			$this->_dbHandle = new PDO($dsn, $user, $pass, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		} catch(PDOException $e) {
			exit('错误：' . $e->getMessage());
		}
	}
	//查询所有
	public function selectAll()
	{
		$sql = sprintf("SELECT * FROM `%s`", $this->_table);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}
	//根据条件(id)查询
	public function select($id)
	{
		$sql = sprintf("SELECT * FROM `%s` WHERE id='%s'", $this->_table, $id);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}
	//根据条件(id)删除
	public function delete($id)
	{
		$sql = sprintf("DELETE FROM `%s` WHERE id='%s'", $this->_table, $id);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->rowCount();
	}
	//自定义sql查询，返回影响的行数
	public function query($sql)
	{
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->rowCount();
	}
	//新增数据
	public function insert($data)
	{
		$sql = sprintf("INSERT INTO `%s` %s", $this->_table, $this->formatInsert($data));

		return $this->query($sql);
	}
	//修改数据
	public function update($id, $data)
	{
		$sql = sprintf("UPDATE `%s` SET %s WHERE `id`='%s'", $this->_table, $this->formatUpdate($data), $id);

		return $this->query($sql);
	} 
	//将数组转换成插入格式的sql语句
	public function formatInsert($data)
	{
		$fields = array();
		$values = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s`", $key);
			$values[] = sprintf("'%s'", $value);
		}
		$field = implode(',', $fields);
		$value = implode(',', $values);

		return sprintf("(%s) values(%s)", $field, $value);

	}
	//将数组转换成更新格式的sql语句
	public function formatUpdate($data)
	{
		$fields = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s` = '%s'", $key, $value);
		}

		return implode(',', $fields);
	}
}