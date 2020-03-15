<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use app\models\Genre;
use app\models\Book;
use app\models\File;
use app\models\UrlHistory;
use app\components\Utils;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class LibraryController extends Controller
{
    private $fsrc;
    private $fbase;
    
    public function init()
    {
        $this->fbase = Yii::$app->basePath . '/web';
        $this->fsrc  = 'data/cover';   
    }


    /**
     * Actions
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'app\components\LibraryErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $categories = Category::find()->all();        
        $books = Book::find()->all();
        
        return $this->render('books', ['categories' => $categories, 'books' => $books]);
    }
    
    public function actionBooks()
    {
        $category   = Yii::$app->request->get('category');
        $genre      = Yii::$app->request->get('genre');
        $categoryId = $this->findCategoryId($category);
        $genreId    = $this->findGenreId($genre, $categoryId);
        $categories = Category::find()->all();
        $books      = $this->findBooks($genreId);
        
        return $this->render('books', ['categories' => $categories, 'books' => $books]);
    }
    
    public function actionBook()
    {
        $cururl = Yii::$app->request->pathInfo;
        $newurl = UrlHistory::getNewUrl($cururl);
        
        if ($cururl != $newurl)
            return $this->redirect(Url::home(true) . $newurl);
        
        $category   = Yii::$app->request->get('category');
        $genre      = Yii::$app->request->get('genre');
        $book       = Yii::$app->request->get('book');
        $categoryId = $this->findCategoryId($category);
        $genreId    = $this->findGenreId($genre, $categoryId);
        $bookId     = $this->findBookId($book, $genreId);
        $categories = Category::find()->all();
        $book       = Book::findOne($bookId);
        
        return $this->render('book', ['categories' => $categories, 'book' => $book]);
    }
    
    /**
     * Find helpers
     */
    private function findItem($id, array $items)
    {
        foreach ($items as $item)
        {
            $name = Utils::transl($item['name']);
            if ($name == $id)
                return $item;
        }
        return false;
    }
    
    private function findCategoryId($name)
    {
        $categories = Category::find()->all();
        $category = $this->findItem($name, $categories);
        if ($category)
            return $category['id'];
        return 0;
    }

    private function findGenreId($name, $categoryId)
    {
        $genres = Genre::find()->where(['category_id' => $categoryId])->all();
        $genre = $this->findItem($name, $genres);
        if ($genre)
            return $genre['id'];
        return 0;
    }
    
    private function findBookId($name, $genreId)
    {
        $books = Book::find()->where(['genre_id' => $genreId])->all();
        $book = $this->findItem($name, $books);
        if ($book)
            return $book['id'];
        return 0;
    }
    
    private function findBookById($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('похоже такой книги нету :(');
        }
    }
    
    private function findBooks($genreId)
    {
        $books = Book::find()->where(['genre_id' => $genreId])->all();
        return $books;
    }
    
    /*
     * Load cover
     */
    private function loadCover($bookId)
    {
        $emsg = 'не удалось загрузить обложку :(';
        
        $file = UploadedFile::getInstanceByName('cover');
        if (!file)
            throw new \Exception($emsg);
        
        $fname = $file->name;
        $fpath = $this->fbase . '/' . $this->fsrc;
        
        if (!file_exists($fpath))
            mkdir($fpath);
        
        $fpath = $this->fbase . '/' . $this->fsrc . '/' . $fname;
        $f = $file->saveAs($fpath);
        if (!$f)
            throw new \Exception($emsg);
        
        $cover = new File();
        $cover->type = 'cover';
        $cover->src = $this->fsrc;
        $cover->name = $fname;
        $cover->book_id = $bookId;
        $cover->save();
        
        return $cover->id;
    }

    /**
     * CRUD
     */
    private function createBook($book, $data)
    {
        if ($book->load($data))
        {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            
            try 
            {
                $book->save();
                $this->loadCover($book->id);
                $transaction->commit();
            } 
            catch (\Exception $e) 
            {
                $transaction->rollBack();
                return $this->redirect('error');
            }
            
            return $book->id;
        }
        return false;
    }
    
    public function actionCreate()
    {
        $book       = new Book();
        $genres     = Genre::find()->orderBy('name')->asArray()->all();
        $genres     = ArrayHelper::map($genres, 'id', 'name');
        $categories = Category::find()->all();
        $id         = $this->createBook($book, Yii::$app->request->post());

        if ($id) {
            return $this->redirect($book->getUrl());
        } else {
            return $this->render('create', ['book' => $book, 'genres' => $genres, 'categories' => $categories]);
        }
    }

    public function actionUpdate($id)
    {
        $book       = $this->findBookById($id);
        $genres     = Genre::find()->orderBy('name')->asArray()->all();
        $genres     = ArrayHelper::map($genres, 'id', 'name');
        $categories = Category::find()->all();
        $oldurl     = $book->getUrl();
        $id         = $this->createBook($book, Yii::$app->request->post());

        if ($id) {
            $url = $book->getUrl();
            UrlHistory::updateUrl($url, $oldurl);
            
            return $this->redirect($url);
        } else {
            return $this->render('update', ['book' => $book, 'genres' => $genres, 'categories' => $categories]);
        }
    }

    public function actionDelete($id)
    {
        $book = $this->findBookById($id);
        $files = File::find()->where(['book_id' => $id])->all();
        
        foreach ($files as $file)
        {
            $fname = $file->name;
            $fpath = $this->fbase . '/' . $this->fsrc . '/' . $fname;

            if (file_exists($fpath))
                unlink($fpath);
        }
        
        File::deleteAll('book_id=' . $id);
        $book->delete();
        
        return $this->redirect(['index']);
    }
}
