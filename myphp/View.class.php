<?php
/**
 *视图基础类
 */
class View
{
	protected $variables = array();
	protected $_controller;
	protected $_action;

	public function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
	}
	//分配变量
	public function assign($name, $value)
	{
		$this->variables[$name] = $value;
	}
	//渲染显示
	public function render()
	{
		extract($this->variables);
		$defaultHeader = APP_PATH . 'application/views/header.php';
		$defaultFooter = APP_PATH . 'application/views/footer.php';
		$view_content = APP_PATH . 'application/views/' . $this->_controller . '/' . $this->_action . '.php';
		$controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
		$controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
		//页头文件
		if (file_exists($controllerHeader)) {
			include($controllerHeader);
		} else {
			include($defaultHeader);
		}
		//页内容文件
		if (file_exists($view_content)) {
			include($view_content);
		} else {
			exit('视图文件不存在');
		}
		//页脚文件
		if (file_exists($controllerFooter)) {
			include($controllerFooter);
		} else {
			include($defaultFooter);
		}
	}
}