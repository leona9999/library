<?php

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->params['categories'] = $categories;

?>

<div class="book-create">
    <h3>Добавить книгу</h3>
    <?= $this->render('bookform', ['book' => $book, 'genres' => $genres]) ?>
</div>
