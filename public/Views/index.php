<?php if (empty($posts)): ?>
    <div class="ac-msg-sorry">对不起，这里没有你想要的文章哦，不要失望，看看其它的~</div>
<?php endif;?>
<?php foreach ($posts as $post): ?>

<article class="blog-main">
    <h3 class="am-article-title blog-title">
        <a href="article/<?=$post['id'];?>.html"><?=$post['title'];?></a>
    </h3>
    <h4 class="am-article-meta blog-meta">
        <span class="am-badge am-badge-primary am-radius"><?=$post['source'];?></span>
        by <a href=""><?=$post['author'];?></a>
        posted on <?php echo date('Y/m/d', $post['publish_date']);?> under
        <?php foreach ($catModel->getCategoriesByArticleId($post['id']) as $cat):?>
        <a href="category/<?=$cat['id'];?>.html"><?=$cat['name']?></a>
        <?php endforeach;?>
    </h4>

    <div class="am-g">
        <div class="am-u-sm-12">
            <?php echo \Demo\Libraries\Tools::blogSummary(
                ($post['model'] == 'markdown' ? $parsedown->parse($post['content']) : $post['content']),
                400
            );?>
        </div>
    </div>
</article>

<hr class="am-article-divider blog-hr">

<?php endforeach; ?>

<ul class="am-pagination blog-pagination">
    <?php if ($page['current'] > 1): ?>
    <li class="am-pagination-prev">
        <a href="<?php
        echo isset($__cat__) ? "category/{$__cat__}.html":'';
        echo isset($__tag__) ? "tag/{$__tag__['name']}.html":"";
        ?>?page=<?=$page['current'] - 1;?>">&laquo; 上一页</a>
    </li>
    <?php endif;?>
    <li class="ac-page-info">共 <?=$page['total']?> 篇文章，每页显示 <?=$page['count'];?> 篇， 总共 <?=$page['page_nums']?> 页，当前第 <?=$page['current']?> 页</li>
    <?php if ($page['current'] < $page['page_nums']): ?>
    <li class="am-pagination-next">
        <a href="<?php
        echo isset($__cat__) ? "category/{$__cat__}.html":'';
        echo isset($__tag__) ? "tag/{$__tag__['name']}.html":"";
        ?>?page=<?=$page['current'] + 1;?>">下一页 &raquo;</a>
    </li>
    <?php endif;?>
</ul>