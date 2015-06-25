<ul class="am-nav am-nav-pills am-topbar-nav">
    <li <?php echo !isset($__navcur__) ? 'class="am-active"' : '';?>><a href="#">首页</a></li>
    <?php foreach ($__navigator__ as $nav): ?>
        <?php if (isset($nav['sub'])) { ?>
            <li class="am-dropdown" data-am-dropdown>
                <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle >
                    <?=$nav['name'];?>
                    <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li class="am-dropdown-header"><?=$nav['name'];?></li>
                    <?php foreach ($nav['sub'] as $k => $v): ?>
                        <li><a href="<?=$v['url'];?>"><?=$v['name'];?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
        <?php } else { ?>
            <li><a href="<?=$nav['url'];?>" <?php echo substr($nav['url'], 0, 7) == 'http://' ? ' target="_blank" ':''; ?>><?=$nav['name'];?></a></li>
        <?php } ?>
    <?php endforeach;?>
</ul>