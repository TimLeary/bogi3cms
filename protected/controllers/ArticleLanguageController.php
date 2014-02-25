<?php

class ArticleLanguageController extends Controller
{
        public $layout='//layouts/column2';
    
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

            if(isset($_POST['Article']))
            {
                    $model->attributes=$_POST['Article'];
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