<?= $this->extend('/post/layout') ?>
<?= $this->section('content') ?>
<?php
foreach($post_list as $post){
    ?>
    <div class="item mb-5">
        <div class="media">
            <!-- <img class="mr-3 img-fluid post-thumb d-none d-md-flex" src="/assets/images/blog/blog-post-thumb-7.jpg" alt="image"> --> <!-- (1) -->
            <div class="media-body">
                <h3 class="title mb-1">
                    <a href="<?= site_url("/post/show/{$post['post_id']}") ?>"><?= $post['title'] ?></a> <!-- (2) -->
                </h3>
                <div class="meta mb-1">
                    <span class="date"><?= $post['created_at'] ?></span> <!-- (3) -->
                    <!-- <span class="comment"><a href="<?= site_url("/post/show/{$post['post_id']}#comment") ?>">4 comments</a></span></div> -->  <!-- (4) -->
                <div class="intro"><?= show_content($post['html_content'])  ?></div>  <!-- (5) -->
                <a class="more-link" href="<?= site_url("/post/show/{$post['post_id']}/#content") ?>">Read more &rarr;</a>  <!-- (6) -->
            </div><!--//media-body-->
        </div><!--//media-->
    </div><!--//item-->
    <?php
}
?>
<?php $pager->setPath("/post"); ?>
<?= $pager->links() ?>
<?php if ($isLogin) : ?>
    <p style="text-align: right;">
        <a href="/post/create" class="btn btn-primary">글쓰기</a>
    </p>
<?php endif ?>
<?= $this->endSection() ?>

<?php
function show_content($content){
    $content = strip_tags($content); // (1)
    if (mb_strlen($content) > 100){ // (2)
        $content = mb_substr($content, 0,100); // (3)
    }
    return $content;
}
?>