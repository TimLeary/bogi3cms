<?php

class ArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'expression' => 'Yii::app()->user->isGuest() === 0',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','create','view','admin','delete','update'),
				'expression' => 'Yii::app()->user->isAdmin() === 1',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $parentId = Yii::app()->request->getParam('parentId',null);
                $seqQuery = Article::model()->getLastSeq($parentId);
                
                if($parentId == null){
                    $model = Article::model()->find('article_status = :articleStatus and article_parent_id is null',array(':articleStatus' => 'inedit'));
                } else {
                    $model = Article::model()->find('article_status = :articleStatus and article_parent_id = :articleParentId',array(':articleStatus' => 'inedit',':articleParentId' => $parentId));
                }
                
                if($model == null){
                    $model = new Article;
                    
                    $model->setAttributes(array(
                        'article_title' => 'tmp',
                        'article_parent_id' => $parentId,
                        'article_seq' => $seqQuery['seq']
                    ));
                    $model->save();
                    $model->setAttribute('article_title','');
                }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                $this->redirect(array('update','id'=>$model->article_id));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			if($model->save()){
                            if(($model->article_parent_id != null)AND($model->article_status == 'active')){
                                $parentModel = Article::model()->find('article_id = :parentId',array(':parentId'=>$model->article_parent_id));
                                if(($parentModel->is_just_parent == null)OR($parentModel->is_just_parent == 0)){
                                    $parentModel->is_just_parent = 1;
                                    $parentModel->save();
                                }
                            }
                            
                            
                            $this->redirect(array('index'));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){
            $model = $this->loadModel($id);
            
            $brothers = Article::model()->getARArticlesByParentId($model->article_parent_id);
            
            if(count($brothers) <= 1){
                if($model->article_parent_id != null){
                    $parent = Article::model()->findByPk($model->article_parent_id);
                    $parent->is_just_parent = null;
                    $parent->save();
                }
            } else {
                $i = 0;
                foreach ($brothers as $brother){
                    if($brother->article_id != $id){
                        $brother->article_seq = $i;
                        $brother->save();
                        ++$i;
                    }
                }
            }
            
            $childs = Article::model()->getARArticlesByParentId($id);
            if(count($childs) <= 1){
                foreach ($childs as $child){
                    $child->delete();
                }
            }
            
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($parentId = null){
            $parentId = Yii::app()->request->getParam('parentId',null);
            $wElderParents = Article::model()->getElderParents($parentId);
            $wArticles = Article::model()->getArticlesByParentId($parentId);
            $this->render('index',array(
                'wArticles'=>$wArticles,
                'wParentId'=>$parentId,
                'wElderParents' => $wElderParents
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
