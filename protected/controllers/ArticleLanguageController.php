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