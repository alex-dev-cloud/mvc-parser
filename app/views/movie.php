<div class="movies-block">
    <div class="row">
        <div class="col-md-4 d-flex justify-content-center"><a class="btn btn-danger" href="<?=URL . 'movie/parser'?>">Refresh movie list</a></div>
        <div class="col-md-8"><?=$data['paginator']?></div>
    </div>
</div>
<?php if(!empty($data['movies'])):?>
    <?php foreach ($data['movies'] as $movie):?>
        <div class="movies-block">
            <div class="row">
                <div class="col-md-4 movie-img-block"><img src="<?= $movie->image?>"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12"><h2 class="text-center" ><?= $movie->name?></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?= $movie->description?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
<?php endif;?>
<div class="movies-block">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8"><?=$data['paginator']?></div>
    </div>
</div>
