<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta name="viewport" content="width=device-width" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <?php
            $cs = Yii::app()->clientScript;
            $cs->registerCoreScript('jquery');
            $cs->registerCoreScript('jquery.ui');
            $cs->registerCssFile($cs->getCoreScriptUrl(). '/jui/css/base/jquery-ui.css');
            $cs->registerCssFile(Yii::app()->baseUrl.'/css/main.css');
            $cs->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
            $cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mousewheel-3.0.6.pack.js');
            $cs->registerCssFile(Yii::app()->baseUrl.'/js/fancyBox/jquery.fancybox.css');
            $cs->registerScriptFile(Yii::app()->baseUrl.'/js/fancyBox/jquery.fancybox.js');
            $cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.backstretch.min.js');
        ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


<div id="backstretch">
    <div id="background-shape">
        <div class="container">
            <div id="logoHolder" class="span-6 last textured">
                <div id="monkeyLogo">

                </div>
            </div>
            <div id="headInfo" class="span-8 last">
                <div id="headInfosHead">
                    <div>
                        <h3>MONKEY ESEMÉNYEK</h3>
                    </div>
                </div>
                <div id="headInfosBody">
                    <ul>
                        <li><div class="eventListItem"></div></li>
                        <li><div class="eventListItem"></div></li>
                        <li><div class="eventListItem"></div></li>
                        <li><div class="eventListItem"></div></li>
                        <li><div class="eventListItem"></div></li>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
                    <div class="span-6 textured top-shift">
                    <ul>
                        <li>
                                <div class="menuListItem subMenuBtn">Gomb 1</div>
                            <ul class="subMenu">
                                <li><div class="menuListItem subMenuItem">algomb 1</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 2</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 3</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 4</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 5</div></li>
                            </ul>
                        </li>
                        <li><div href="#" class="menuListItem">Gomb 2</div></li>
                        <li><div href="#" class="menuListItem">Gomb 3</div></li>
                        <li><div href="#" class="menuListItem">Gomb 4</div></li>
                        <li>
                                <div class="menuListItem subMenuBtn">Gomb 5</div>
                            <ul class="subMenu">
                                <li><div class="menuListItem subMenuItem">algomb 1</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 2</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 3</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 4</div></li>
                                <li><div class="menuListItem subMenuItem">algomb 5</div></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <div class="span-18 textured top-shift last">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="span-5 last">

            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
        <div class="clear"></div>
        <div class="container" id="page">
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->

</body>
</html>
