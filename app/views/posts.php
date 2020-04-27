
<?php if(!empty($_SESSION['user'])):?>
<div class="post-block">
    <form action="" method="post">
            <div class="form-group post-title">
                <input id="postTitle" name="postTitle" type="text" class="form-control" placeholder="Title of your post">
                <div id="title-error" class="error-box"></div>
            </div>
            <div class="form-group post-content">
                <textarea id="postContent" name="postContent" rows="3" class="form-control" placeholder="Your message"></textarea>
                <div id="content-error" class="error-box"></div>
            </div>
        <button type="submit" class="btn btn-primary ml-auto">Leave post</button>
    </form>
</div>
<?php else:;?>
    <div class="post-block">
        <h2 class="text-center">Sign in to leave your message</h2>
    </div>
<?php endif;?>
<div class="post-block">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8"><?=$data['paginator']?></div>
    </div>
</div>
<?php if(!empty($data['posts'])):?>
    <?php foreach ($data['posts'] as $post):?>

        <div class="post-block">
            <h3 class="text-center"><?=$post->title?></h3>
            <p><?=$post->content?></p>
            <span><?=date('d-m-Y H:i:s', $post->created)?></span>
            <span><?=$post->login?></span>
        </div>
    <?php endforeach;?>
<?php endif;?>
<div class="post-block">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8"><?=$data['paginator']?></div>
    </div>
</div>
<script src="<?=URL . 'public/assets/js/posts.js'?>"></script>
