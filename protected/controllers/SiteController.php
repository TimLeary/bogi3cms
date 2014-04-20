<?php

class SiteController extends Controller
{
    
        public $menuItems;

        /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            $model=new ContactForm;
            if(isset($_POST['ContactForm']))
            {
                $model->attributes=$_POST['ContactForm'];
                if($model->validate())
                {
                    $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                    $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                    $headers="From: $name <{$model->email}>\r\n".
                            "Reply-To: {$model->email}\r\n".
                            "MIME-Version: 1.0\r\n".
                            "Content-Type: text/plain; charset=UTF-8";

                    mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                    Yii::app()->user->setFlash('contact',Yii::t('site','Thank you for contacting us. We will respond to you as soon as possible.'));
                    $this->refresh();
                }
            }
            
            $this->layout = "main_site";
            
            $language = Yii::app()->request->getParam('language',null);
            $languageId = Language::model()->getLanguageId($language);
            $menuItems = ArticleLanguage::model()->getBasicMenu(null, $languageId);

            $showChilds = Yii::app()->request->getParam('showChilds',null);
            $showItem = Yii::app()->request->getParam('showItem',null);

            if(($showChilds == null)AND($showItem == null)){
                $firstChild = ArticleLanguage::model()->getVeryFirstChild($languageId);
                if($firstChild['is_just_parent'] == 1){
                    $showChilds = $firstChild['article_id'];
                } else {
                    $showItem = $firstChild['article_id'];
                }
            }

            if($showChilds != null){
                $wArticles = Article::model()->getArticlesByParentId($showChilds);
            } else {
                $wArticles = Article::model()->getArticleById($showItem);
            }
            $this->menuItems = $this->generateMenuStr($menuItems);
            $this->render('index',array('menuItems' => $menuItems,'wArticles'=>$wArticles, 'model'=>$model));
	}
        
        protected function generateMenuStr($menuItems){
            $menuLinks = $this->menuItemsToStr($menuItems);
            return $menuLinks;
        }
        
        protected function menuItemsPrepare($items){
            $returnArray = array();
            foreach ($items as $item){
                $tmpItem = array();
                $tmpItem['label'] = $item['article_title'];
                $tmpUrlArray = array();
                if(($item['is_just_parent']==1)AND(($item['is_just_link'] == 0)OR($item['is_just_link'] == null))){
                    $tmpItem['url'] = Yii::app()->createUrl('site/index',array('showChilds'=>$item['article_id']));
                } else if(($item['is_just_parent']==1)AND($item['is_just_link'] == 1)){
                    $tmpSubItems = $this->menuItemsPrepare($item['childs']);
                    $tmpItem['items'] = $tmpSubItems;
                } else if (($item['is_just_parent']==0)AND(($item['is_just_link'] == 0)OR($item['is_just_link'] == null))){
                    $tmpItem['url'] = Yii::app()->createUrl('site/index',array('showChilds'=>$item['article_id']));
                } else if (($item['is_just_parent']==0)AND($item['is_just_link'] == 1)){
                    $tmpItem['url'] = $item['link'];
                }

                $returnArray[] = $tmpItem;

            }
            
            return $returnArray;
        }
        
        protected function menuItemsToStr($items, $hasParent = false){
            $returnStr = "";
            $addDivClass = "";
            $addUlClass = "";
            
            if($hasParent == true){
                $addUlClass = ' class="subMenu" ';
                $addDivClass = " subMenuItem";
            }
            
            $returnStr .= '<ul'.$addUlClass.'>';

            foreach ($items as $item){
                
                
                if((is_array($item['childs']))AND(count($item['childs'])>=1)AND($item['is_just_link'] == 1)){
                    $divStr = '<div class="menuListItem subMenuBtn">';
                    $divStr .= $item['article_title'];
                    $divStr .= '</div>';
                    
                    $returnStr .= '<li>'.$divStr;
                    $childStr = $this->menuItemsToStr($item['childs'],true);
                    $returnStr .= $childStr;
                    $returnStr .= '</li>';
                } else {
                    $divStr = "";
                    if($item['is_just_parent']==1){
                        $divStr .= "<div href=\"".Yii::app()->createUrl('site/index',array('showChilds'=>$item['article_id']))."\" class=\"menuListItem".$addDivClass."\">";
                    }elseif($item['is_just_link'] == 1) {
                        $divStr .= "<div href=\"".$item['link']."\" class=\"menuListItem".$addDivClass."\">";
                    } else {
                        $divStr .= "<div href=\"".Yii::app()->createUrl('site/index',array('showItem'=>$item['article_id']))."\" class=\"menuListItem".$addDivClass."\">";
                    }
                    
                    $divStr .= $item['article_title'];
                    $divStr .= '</div>';
                    
                    $returnStr .= '<li>'.$divStr.'</li>';
                }
                
            }
            $returnStr .= '</ul>';
            
            return $returnStr;
        }
        
        /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}