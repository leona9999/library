<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->params['categories'] = $categories;

?>

<div class="book-update">
    <h3>Изменить</h3>
    <?= $this->render('bookform', ['book' => $book, 'genres' => $genres]) ?>
</div>
