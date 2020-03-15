<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['categories'] = $categories;

?>

<?php if ($book): ?>

<div class="book">
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
    <p class="book-action">
        <a href="<?= Url::to(['update', 'id' => $book->id]) ?>" title="">Изменить</a>
        <a href="<?= Url::to(['delete', 'id' => $book->id]) ?>" title="">Удалить</a>
    </p>
</div>

<?php else: ?>

<p class="empty">упс... похоже здесь ничего нету (</p>

<?php endif ?>
