<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>404 - AICODE.CC</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="description" content="管宜尧的博客 - AICODE.CC">
    <meta name="author" content="管宜尧, mylxsw">
    <meta name="keywords" content="PHP, Linux, AiCode, 管宜尧">

    <base href="http://<?=$_SERVER['HTTP_HOST'];?>">

    <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.0/css/amazeui.min.css"/>
    <link rel="stylesheet" href="Views/assets/css/style.css" />
    <link rel="shortcut icon" href="http://source.aicode.cc/logo/favicon.png">

</head>
<body>
<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="http://aicode.cc" data-am-offcanvas="{target: '#doc-oc-demo2', effect: 'push'}">AICODE</a>
    </h1>

    <!-- 侧边栏内容 -->
    <div id="doc-oc-demo2" class="am-offcanvas">
        <div class="am-offcanvas-bar">
            <div class="am-offcanvas-content">
                <p>
                    <br />
                    如果你有梦想 <br/>
                    就要去捍卫它 <br/>
                    当别人做不到的时候 <br/>
                    他们会告诉你 <br/>
                    你也不能 <br/>
                    如果你想要做些什么 <br/>
                    就得去努力争取 <br/>
                    就这样
                </p>
                <p style="text-align: center">
                    <img src="http://source.aicode.cc/logo/weixin-qcode.jpg" style="width: 95%">
                    <span style="margin-top: 10px; display: block;">扫码关注微信公众号 <br /> 人文与技术</span>
                </p>
            </div>
        </div>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span
            class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
        <form action="https://www.baidu.com/s" method="get" class="am-topbar-form am-topbar-left am-form-inline am-topbar-right" role="search">
            <div class="am-form-group">
                <input type="text" name="wd" class="am-form-field am-input-sm" placeholder="搜索文章">
            </div>
            <button type="submit" class="am-btn am-btn-default am-btn-sm">搜索</button>
        </form>
    </div>
</header>
<div class="am-g am-g-fixed blog-g-fixed">
<div class="am-g">
    <div class="am-u-sm-12">
        <h2 class="am-text-center am-text-xxxl am-margin-top-lg">404. Not Found</h2>
        <p class="am-text-center">没有找到你要的页面</p>
        <p class="ac-msg-sorry" style="padding: 30px;"></p>
    </div>
</div>

</div>
<footer class="blog-footer">
    <p>aicode.cc <script src="http://v1.cnzz.com/z_stat.php?id=1000419659&web_id=1000419659" language="JavaScript"></script><br/>
        <small><a href="http://www.miitbeian.gov.cn" target="_blank">鲁ICP备14009006号</a>  © Copyright <?php echo date('Y');?>. by mylxsw.</small>
    </p>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.4.0/js/amazeui.legacy.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.4.0/js/amazeui.min.js"></script>
<!--<![endif]-->

<script>
    window.duoshuoQuery = {short_name: "orionis"};
    window.setTimeout(function() {
        $(".ds-loading").fadeOut("fast");
    }, 3000);
</script>
<script src="http://static.duoshuo.com/embed.js"></script>
<script src="Views/assets/js/app.js"></script>

</body>
</html>