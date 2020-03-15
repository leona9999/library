<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "url".
 *
 * @property integer $id
 * @property string $url
 * @property string $old_url
 */
class UrlHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'old_url'], 'required'],
            [['url', 'old_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'old_url' => 'Old Url',
        ];
    }
    
    /**
     * Update url history
     */
    public static function updateUrl($url, $oldurl)
    {
        if (is_array($url))
            $url = Url::to($url);
        
        if (is_array($oldurl))
            $oldurl = Url::to($oldurl);
        
        if ($url[0] == '/')
            $url = mb_substr ($url, 1);
        
        if ($oldurl[0] == '/')
            $oldurl = mb_substr ($oldurl, 1);
        
        if ($url == $oldurl)
            return false;
        
        $newurl = new UrlHistory();
        $newurl->url = $oldurl;
        $newurl->old_url = $oldurl;
        $newurl->save();
        
        $urls = UrlHistory::find()->where(['url' => $oldurl])->all();
        foreach ($urls as $u)
        {
            $u->url = $url;
            $u->save();
        }
        
        return true;
    }
    
    /**
     * Returns new url for old url if exists
     */
    public static function getNewUrl($oldurl)
    {
        $newurl = UrlHistory::find()->where(['old_url' => $oldurl])->one();
        if ($newurl)
            return $newurl['url'];
        return $oldurl;
    }
}
