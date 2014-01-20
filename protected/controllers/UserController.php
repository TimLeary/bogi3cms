<?php

class UserController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','register','loginBox','login','logout'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create' and 'update' and 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','changePassword'),
				'expression' => 'Yii::app()->user->isAdmin() === 1',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function actionRegister(){
            $model = new User;
            
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            if(isset($_POST['User'])){
                $model->attributes = $_POST['User'];
                $model->user_status = 'normal';
                $password = $model->generatePassword();
                $model->password = $model->hashPassword($password);

                if($model->save()){
                    $this->sendRegistrationEmail($model->getAttributes(), $password);
                    echo 'user saved';
                    $cs->registerScript('userSaved','
                        $(\'#registerBox\').dialog("close");
                        $.ajax({
                            url:"'.Yii::app()->createUrl('user/loginBox').'",
                            success: function(data){
                                $(\'div#loginBox\').empty();
                                $(\'div#loginBox\').append(data);
                                displayMessage(\''.Yii::t('user','registration_success').'\',"info");
                            }
                        });
                        ',CClientScript::POS_END);
                }
            }
            
            $this->renderPartial('_registerform',array('model' => $model),FALSE,TRUE);
        }
        
        protected function sendRegistrationEmail($userAttributes,$password){
            $mail = new YiiMailer();
            $mail->setView('registry');
            
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            //$mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = Yii::app()->params['smtpHost'];
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = Yii::app()->params['smtpPort'];
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = Yii::app()->params['smtpSecure'];
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = Yii::app()->params['smtpUser'];
            //Password to use for SMTP authentication
            $mail->Password = Yii::app()->params['smtpPass'];
            //Set who the message is to be sent from
            $mail->setFrom(Yii::app()->params['smtpUser'], Yii::app()->params['mailFrom']);
            $mail->setTo($userAttributes['email']);
            $mail->setSubject(Yii::t('user','registration_mail'));
            $mail->setData(array(
                'username' => $userAttributes['username'],
                'password' => $password,
                'mail' => $mail
            ));
            
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        }


        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
        
        public function actionChangePassword(){
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            
            $wChangePass = new ChangePassForm();
            if(isset($_POST['ChangePassForm'])){
                $wChangePass->setAttributes($_POST['ChangePassForm']);
                if($wChangePass->validate()){
                    if($wChangePass->changePassword()){       
                        $cs->registerScript('passwordChanged','
                            $(\'#changePassBox\').dialog("close");
                            displayMessage(\''.Yii::t('user','password_changed_successfull').'\',"info");
                            ',CClientScript::POS_END);
                    }   
                }
            }
            $this->renderPartial('_changePassword',array('model' => $wChangePass),FALSE,TRUE);
        }

        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
            
        public function actionLoginBox(){
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            
            if(Yii::app()->user->isGuest == true){
                $wRegister = new User;
                $wLogin = new LoginForm;
                
                $cs->registerScript('logreg',
                    "$('a#registry').on('click',function(){
                        //console.log('a#registry clicked');
                        $('#registerBox').dialog('open');
                    });

                    $('a#login').on('click',function(){
                        $('#loginformBox').dialog('open');
                    });",
                    CClientScript::POS_END
                );
                
                $this->renderPartial('_loginBox',array('register' => $wRegister,'login'=>$wLogin),FALSE,TRUE);
            } else {
                $wChangePass = new ChangePassForm;
                
                $cs->registerScript('logou',
                    "$('a#changePass').on('click',function(){
                        //console.log('a#changePass clicked');
                        $('#changePassBox').dialog('open');
                    });
                    $('a#logout').on('click',function(){
                        $.ajax({
                            url:\"".Yii::app()->createUrl('user/logout')."\",
                            success: function(data){
                                location.reload();
                                /*
                                console.log(data);
                                $('div#loginBox').append(data);
                                */
                            }
                        });
                    });",
                    CClientScript::POS_END
                );
                $this->renderPartial('_userBox',array('changePass' => $wChangePass),FALSE,TRUE);
            }
        }

        
        public function actionLogin(){
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            
            $model = new LoginForm;
            
            if(isset($_POST['LoginForm'])){
                $model->attributes=$_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->login()){
                    
                    $cs->registerScript('validUser','
                        $(\'#loginformBox\').dialog("close");
                        $.ajax({
                            url:"'.Yii::app()->createUrl('user/loginBox').'",
                            success: function(data){
                                location.reload();
                                /*
                                $(\'div#loginBox\').empty();
                                $(\'div#loginBox\').append(data);
                                */
                            }
                        });
                        ',CClientScript::POS_END);
                     
                }
            }
            $this->renderPartial('_loginform',array('model' => $model),FALSE,TRUE);
        }
        
        
        public function actionLogout(){
            Yii::app()->user->logout();
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            $cs->registerScript('reloadLoginBox',
                "$.ajax({
                    url:'".Yii::app()->createUrl('user/loginBox')."',
                    success: function(lbox){
                        $('div#loginBox').empty();
                        $('div#loginBox').append(lbox);
                    }
                });",
                CClientScript::POS_END);
            $this->renderPartial('_logout',array(),FALSE,TRUE);
        }

        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
