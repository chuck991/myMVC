<?php

//初始化常量
//当前路径在myphp下
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__ . '/');
//根目录为执行文件时所在的目录（路口文件为index.php引入此配置）
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
defined('APP_DEBUG') or define('APP_DEBUG', false);
defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH . 'config/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'runtime/');
//包含配置文件
require CONFIG_PATH . 'config.php';
// 包含核心框架类
require FRAME_PATH . 'core.php';
//实例化核心类
$fast = new Core;
$fast->run();