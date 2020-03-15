<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],]); ?>

    <?= $form->field($book, 'genre_id')->dropDownList($genres) ?>

    <?= $form->field($book, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'publishers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'year')->textInput() ?>

    <?= $form->field($book, 'isbn')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::label('Обложка', 'cover') ?>
        <?= Html::fileInput('cover', null, ['class' => 'file', 'id' => 'cover', 'required' => true]) ?>
    </div>

    <?= $form->field($book, 'annotation')->textarea(['rows' => 9]) ?>

    <div class="form-group">
        <?= Html::submitButton($book->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $book->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
