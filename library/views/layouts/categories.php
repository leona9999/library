<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\components\Utils;

?>
                
<ul class="categories">
    <?php foreach ($categories as $category): ?>
        <li class="category">
            <div class="category-name"><?= $category->name ?></div>
            <ul class="genres">
                <?php foreach ($category->genres as $genre): ?>
                    <li class="genre">
                        <a href="<?= Url::to(['books', 'category' => Utils::transl($category->name), 'genre' => Utils::transl($genre->name)]) ?>" 
                           title="<?= $genre->name ?>"><?= $genre->name ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </li>
    <?php endforeach ?>
</ul>
