<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

$this->title = 'Library';
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= Url::home(true) ?>" title="Library home page">Library</a>
        </div>
      </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <?= $content ?>
            </div>
            
            <div class="col-lg-3 col-md-3">
                <?php if (count($this->params['categories'])): ?>
                    <div class="action">
                        <a href="<?= Url::to('/library/create') ?>" title="Добавить книгу">Добавить книгу</a>
                    </div>
                    <?= $this->render('categories.php', ['categories' => $this->params['categories']]) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <span class="copyright">Leonid, (c) 2015</span>
            </div>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
