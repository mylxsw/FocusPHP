<article class="blog-main">
    <h3 class="am-article-title blog-title">
        <a href="post?id=<?=$post['id'];?>"><?=$post['title'];?></a>
    </h3>
    <h4 class="am-article-meta blog-meta">by <a href=""><?=$post['author'];?></a>
        posted on <?php echo date('Y/m/d', $post['publish_date']);?> under <a href="#">MIT</a></h4>

    <div class="am-g">
        <div class="am-u-sm-12">
            <?php echo $parsedown->parse($post['content']);?>
        </div>
    </div>
</article>


<div class='ds-thread' data-thread-key="art_<?=$post['id'];?>"></div>
<script>
    window.duoshuoQuery = {short_name: "orionis"};
</script>
<script src="http://static.duoshuo.com/embed.js"></script>