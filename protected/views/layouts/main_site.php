<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

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
        ?>
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<?php
function menuItemForItemArray($items){
    $returnArray = array();
    foreach ($items as $item){
        $tmpItem = array();
        $tmpItem['label'] = $item['article_title'];
        $tmpUrlArray = array();
        if(($item['is_just_parent']==1)AND(($item['is_just_link'] == 0)OR($item['is_just_link'] == null))){
            $tmpUrlArray = array('/site/index','showChilds'=>$item['article_id']);
            $tmpItem['url'] = $tmpUrlArray;
        } else if(($item['is_just_parent']==1)AND($item['is_just_link'] == 1)){
            $tmpSubItems = menuItemForItemArray($item['childs']);
            $tmpItem['items'] = $tmpSubItems['items'];
        } else if (($item['is_just_parent']==0)AND(($item['is_just_link'] == 0)OR($item['is_just_link'] == null))){
            $tmpUrlArray = array('/site/index','showItem'=>$item['article_id']);
            $tmpItem['url'] = $tmpUrlArray;
        } else if (($item['is_just_parent']==0)AND($item['is_just_link'] == 1)){
            $tmpItem['url'] = $item['link'];
        }
        
        $returnArray['items'][] = $tmpItem;
        
    }
    return $returnArray;
}


$itemsMenu = menuItemForItemArray($this->menuItems);
?>
<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->
        <div id="mainMbMenu">
            <?php $this->widget('application.extensions.mbmenu.MbMenu',$itemsMenu); ?>
        </div>
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
