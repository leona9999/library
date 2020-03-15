<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'bootstrap-fileinput/css/fileinput.min.css'
    ];
    public $js = [
        'bootstrap-fileinput/js/fileinput.min.js',
        'bootstrap-fileinput/js/fileinput_locale_ru.js'
    ];
}
