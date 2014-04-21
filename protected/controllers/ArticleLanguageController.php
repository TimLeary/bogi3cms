<?php

class ArticleLanguageController extends Controller
{
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
                        'actions'=>array('index','create','update','changeSort','imageUpload','fileUpload'),
                        'expression' => 'Yii::app()->user->isAdmin() === 1',
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
            );
	}
    
	public function actionIndex(){
            $actualLanguage = Yii::app()->request->getParam('language',null);
            $activeLanguages = Language::model()->getActiveLanguages();
            
            $languageArr = array();
            if($activeLanguages != null){
                foreach ($activeLanguages as $lan){
                    $languageArr[] = $lan['language_code'];
                }
                
                if(($actualLanguage == null)OR(!in_array($actualLanguage, $languageArr))){
                    $actualLanguageId = $activeLanguages[0]['language_id'];
                    $actualLanguage = $activeLanguages[0]['language_code'];
                } else {
                    $langData = Language::model()->getLanguageByLanguageCode($actualLanguage);
                    $actualLanguageId = $langData['language_id'];
                }
            }
            
            
            $parentId = Yii::app()->request->getParam('parentId',null);
            $wElderParents = ArticleLanguage::model()->getElderParents($parentId);
            $wArticles = ArticleLanguage::model()->getArticlesByParentId($parentId,'all',$actualLanguageId);
            
            $this->render('index',array(
                'wArticles'=>$wArticles,
                'wParentId'=>$parentId,
                'wElderParents' => $wElderParents,
                'activeLanguages'=>$activeLanguages,
                'actualLanguage'=>$actualLanguage
            ));
	}
        
        public function actionCreate(){
            $parentId = Yii::app()->request->getParam('parentId',null);
            $language = Yii::app()->request->getParam('language',null);
            
            $languageArr = Language::model()->getLanguageByLanguageCode($language);
            
            $seqQuery = ArticleLanguage::model()->getLastSeq($parentId);

            if($parentId == null){
                $model = ArticleLanguage::model()->find('article_status = :articleStatus and article_parent_id is null and article_language_id = :languageId',array(':articleStatus' => 'inedit',':languageId'=>$languageArr['language_id']));
            } else {
                $model = ArticleLanguage::model()->find('article_status = :articleStatus and article_parent_id = :articleParentId and article_language_id = :languageId',array(':articleStatus' => 'inedit',':articleParentId' => $parentId, ':languageId'=>$languageArr['language_id']));
            }

            if($model == null){
                $model = new ArticleLanguage;

                $model->setAttributes(array(
                    'article_title' => 'tmp',
                    'article_parent_id' => $parentId,
                    'article_language_id'=> $languageArr['language_id'],
                    'article_seq' => $seqQuery['seq']
                ));
                $model->save();
                $model->setAttribute('article_title','');
            }
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $this->redirect(array('update','id'=>$model->article_id));
        }
        
        
        public function actionUpdate($id){   
            //var_dump(Yii::app()->basePath.'/images/uploaded/original/',Yii::app()->baseUrl.'/images/uploaded/original/');
            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['ArticleLanguage']))
            {
                    $model->attributes=$_POST['ArticleLanguage'];
                    if($model->save()){
                        if(($model->article_parent_id != null)AND($model->article_status == 'active')){
                            $parentModel = ArticleLanguage::model()->find('article_id = :parentId',array(':parentId'=>$model->article_parent_id));
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
        
        public function actionChangeSort(){
            $parentId = Yii::app()->request->getParam('parentId',null);
            $childs = ArticleLanguage::model()->getARArticlesByParentId($parentId);
            $newOrderStr = Yii::app()->request->getParam('newOrderStr');
            $newOrder = CJSON::decode($newOrderStr);
            
            foreach ($childs as $child){
                $child->article_seq = array_search($child->article_id, $newOrder['newOrder']);
                $child->save();
            }
            
        }
        
        public function actionFileUpload(){
            $this->layout = '//layouts/ajax';
            //header('Content-type: application/json');
            $uploadPath = realpath(Yii::app()->basePath . '/../uploads/article/');
            //var_dump($uploadPath);
            $uploadUrl = Yii::app()->baseUrl.'/uploads/article/';
            $file = CUploadedFile::getInstanceByName('file');
            //var_dump($this); exit();
            if ($file instanceof CUploadedFile) {
                    $fileName = $file->name;
                    
                    $path = $uploadPath.DIRECTORY_SEPARATOR.$fileName;
                    
                    if (file_exists($path) || !$file->saveAs($path)) {
                            echo CJSON::encode(
                                    array('error'=>'Could not save file or file exists: "'.$path.'".')
                            ); Yii::app()->end();
                    }
                    $attributeUrl = $uploadUrl.$fileName;
                    $data = array(
                            'filelink'=>$attributeUrl,
                            'filename' => $file->name
                    );
                    
                    echo CJSON::encode($data);
                    Yii::app()->end();
            } else {
                    echo CJSON::encode(
                        array('error'=>'Could not upload file.')
                    ); Yii::app()->end();
            }
        
        }
        
        public function actionImageUpload(){
            $this->layout = '//layouts/ajax';
            //header('Content-type: application/json');
            $uploadPath = realpath(Yii::app()->basePath . '/../images/uploaded/original/');
            //var_dump($uploadPath);
            $uploadUrl = Yii::app()->baseUrl.'/images/uploaded/original/';
            $file = CUploadedFile::getInstanceByName('file');
            //var_dump($this); exit();
            if ($file instanceof CUploadedFile) {
                    if (!in_array(strtolower($file->getExtensionName()),array('gif','png','jpg','jpeg'))) {
                            echo CJSON::encode(
                                    array('error'=>'Invalid file extension '. $file->getExtensionName().'.')
                            ); Yii::app()->end();
                    }
                    $fileName=trim(md5(time().uniqid(rand(),true))).'.'.$file->getExtensionName();
                    
                    $path = $uploadPath.DIRECTORY_SEPARATOR.$fileName;
                    
                    if (file_exists($path) || !$file->saveAs($path)) {
                            echo CJSON::encode(
                                    array('error'=>'Could not save file or file exists: "'.$path.'".')
                            ); Yii::app()->end();
                    }
                    $attributeUrl=$uploadUrl.$fileName;
                    $data = array(
                            'filelink'=>$attributeUrl,
                    );
                    echo CJSON::encode($data);
                    Yii::app()->end();
            } else {
                    echo CJSON::encode(
                        array('error'=>'Could not upload file.')
                    ); Yii::app()->end();
            }
        
        }
        
        
        public function loadModel($id){
		$model= ArticleLanguage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}