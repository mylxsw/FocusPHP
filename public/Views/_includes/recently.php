<section class="am-panel am-panel-default">
    <div class="am-panel-hd">标签</div>
    <div class="am-panel-bd am-animation-fade">
        <?php foreach ($__tags__ as $tag): ?>
        <a class="am-badge am-radius" href="tag/<?=$tag['name'];?>.html"><?=$tag['name'];?></a>
        <?php endforeach;?>
    </div>
</section>