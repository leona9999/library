<?php

namespace app\components;

use Yii;
use yii\web\ErrorAction;

class LibraryErrorAction extends ErrorAction
{
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
