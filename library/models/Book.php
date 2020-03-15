<?php

namespace app\models;

use Yii;
use app\components\Utils;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $author
 * @property string $publishers
 * @property integer $year
 * @property string $isbn
 * @property string $annotation
 * @property integer $genre_id
 *
 * @property Genre $genre
 * @property File[] $files
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'author', 'annotation', 'genre_id'], 'required'],
            [['year', 'genre_id'], 'integer'],
            [['annotation'], 'string'],
            [['name', 'author', 'publishers'], 'string', 'max' => 50],
            [['isbn'], 'string', 'max' => 20],
            [['name', 'author'], 'match', 'pattern' => '/^[a-zA-Zа-яА-ЯёЁ0-9,-\:\'\.\s]+$/u', 'message' => 'Введен недопустимый символ'],
            [['isbn'], 'match', 'pattern' => '/^[0-9-]+$/', 'message' => 'Введен недопустимый символ'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'author' => 'Автор',
            'publishers' => 'Издательство',
            'year' => 'Год',
            'isbn' => 'ISBN',
            'annotation' => 'Аннотация',
            'genre_id' => 'Жанр',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['book_id' => 'id']);
    }
    
    /**
     * @return string
     */
    public function getCover()
    {
        $files = $this->getFiles();
        $cover = $files->where(['type' => 'cover'])->orderBy('id DESC')->one();
        return '/' . $cover->src . '/' . $cover->name;
    }
    
    /**
     * return string
     */
    public function getUrl()
    {
        $this->refresh();
        $this->genre->refresh();
        $this->genre->category->refresh();
        
        return ['book', 
                'category' => Utils::transl($this->genre->category->name), 
                'genre' => Utils::transl($this->genre->name), 
                'book' => Utils::transl($this->name)
            ];
    }
}
