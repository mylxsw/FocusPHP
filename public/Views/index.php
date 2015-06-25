<?php foreach ($posts as $post): ?>

<article class="blog-main">
    <h3 class="am-article-title blog-title">
        <a href="post?id=<?=$post['id'];?>"><?=$post['title'];?></a>
    </h3>
    <h4 class="am-article-meta blog-meta">by <a href=""><?=$post['author'];?></a>
        posted on <?php echo date('Y/m/d', $post['publish_date']);?> under <a href="#">MIT</a></h4>

    <div class="am-g">
        <div class="am-u-sm-12">
            <?php echo \Demo\Libraries\Tools::blogSummary($parsedown->parse($post['content']), 400);?>
        </div>
    </div>
</article>

<hr class="am-article-divider blog-hr">

<?php endforeach; ?>

<ul class="am-pagination blog-pagination">
    <?php if ($page['current'] != 1): ?>
    <li class="am-pagination-prev"><a href="<?php echo isset($cat) ? 'list':''; ?>?page=<?=$page['current'] - 1;?><?php echo isset($cat) ? "&cat={$cat}" : ''; ?>">&laquo; 上一页</a></li>
    <?php endif;?>
    <?php if ($page['current'] != $page['page_nums']): ?>
    <li class="am-pagination-next"><a href="<?php echo isset($cat) ? 'list':''; ?>?page=<?=$page['current'] + 1;?><?php echo isset($cat) ? "&cat={$cat}" : ''; ?>">下一页 &raquo;</a></li>
    <?php endif;?>
</ul>