# FocusPHP
FocusPHP is a micro php framework

##TODO

- 完善docker开发环境
- 增加后台管理
- 框架与项目分离

##备注

数据库文件中，username=admin, password=administrator


##安装使用

    composer require aicode/focusphp

###MVC支持

框架本身可选的对`MVC`提供了支持，只需要在创建`Focus\Server`对象时注册`Focus\MVC\Router`对象即可。

    $server->registerRouter(new Focus\MVC\Router('Demo\Controllers'));

创建`Focus\MVC\Router`是需要提供控制器命名空间作为参数，这样框架就回到该命名空间下寻找适合处理当前请求的控制器。

####视图对象

视图类需要实现`Focus\MVC\View`接口，框架内置了一套简单的视图实现`Focus\MVC\SimpleView`，
该实现使用`.php`文件作为视图文件模板，在模板文件中，直接使用原始的PHP语法即可。

默认视图`Focus\MVC\SimpleView`提供了layout支持。

隐藏的模板变量

| 变量名            | 说明
|------------------|---------
| `__body__`       | 解析模板后的内容，该变量只在layout中可用
| `__data__`       | 给模板对象传递的字符串数据（无key）


###框架异常消息

| 消息                       | 含义
|---------------------------|----------
| INVALID_ROUTER            | 路由不合法
| INVALID_ROUTER_ARGS       | 路由参数不合法
| INVALID_ROUTER_FUNC       | 路由规则执行函数不合法
| NONSUPPORT_PHP_VERSION    | PHP版本不支持，请使用5.6.0以上版本
| CONFIG_FILE_NOT_FOUND     | 配置文件不存在
| INVALID_CONFIG_FORMAT     | 不合法的配置文件格式