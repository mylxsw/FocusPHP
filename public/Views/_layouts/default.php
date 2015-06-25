<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>AICODE.CC</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <base href="http://<?=$_SERVER['HTTP_HOST'];?>">

    <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.0/css/amazeui.min.css"/>
    <link rel="stylesheet" href="Views/assets/css/style.css" />
</head>
<body>
<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="#">AICODE</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span
            class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
        <?=$__nav__?>

        <form class="am-topbar-form am-topbar-left am-form-inline am-topbar-right" role="search">
            <div class="am-form-group">
                <input type="text" class="am-form-field am-input-sm" placeholder="搜索文章">
            </div>
            <button type="submit" class="am-btn am-btn-default am-btn-sm">搜索</button>
        </form>

    </div>
</header>

<div class="am-g am-g-fixed blog-g-fixed">
    <div class="am-u-md-8">
        <?=$__body__?>
    </div>

    <div class="am-u-md-4 blog-sidebar">
        <div class="am-panel-group">
            <?php if (isset($__sidebars__) && is_array($__sidebars__)):foreach ($__sidebars__ as $sidebar): ?>
                <?=$sidebar?>
            <?php endforeach;endif;?>
        </div>
    </div>

</div>

<footer class="blog-footer">
    <p>aicode.cc<br/>
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

</body>
</html>
