<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['categories'] = $categories;

?>

<?php if (count($books)): ?>

<ul class="books">
    <?php foreach ($books as $book): ?>
        <li class="book">
            <p class="cover"><img src="<?= $book->getCover() ?>" alt="<?= Html::encode($book->name) ?>" width="200" height="330"></p>
            <p class="name"><?= Html::encode($book->name) ?></p>
            <p class="author"><?= Html::encode($book->author) ?></p>
            <p class="publishers">Издательство "<?= Html::encode($book->publishers) ?>"</p>
            <p class="year"><?= Html::encode($book->year) ?> г.</p>
            <p class="isbn">ISBN <?= Html::encode($book->isbn) ?></p>
            <p class="annotation">
                <span class="caption">Аннотация</span>
                <span class="description"><?= nl2br(Html::encode($book->annotation)) ?></span>
            </p>
            <p class="detailed">
                <a href="<?= Url::to($book->getUrl()) ?>" title="">Подробнее...</a>
            </p>
        </li>
    <?php endforeach ?>
</ul>

<?php else: ?>

<p class="empty">упс... похоже здесь ничего нету (</p>

<?php endif ?>
