<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <meta name="description" content="<?= $this->desc ?>" />
        <meta name="keywords" content="<?= $this->keywords ?>" />
        <meta name="robots" content="all" />
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
        
	<title><?php echo CHtml::encode($this->title.' - '.$this->pageTitle); ?></title>
</head>
<body>
<div id="backstretch">
    <div id="background-shape">
        <div class="container">
            <div id="logoHolder" class="span-6 last textured">
                <div id="monkeyLogo">

                </div>
            </div>
            <div id="headInfo" class="span-8 last" style="display: none;">
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
                        <?= $this->menuItems ?>
                        <!--
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
                        -->
                </div>
            <div class="span-18 textured top-shift last contentContainer">
                <?php echo $content; ?>
            </div>
            <div class="span-5 last"></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    $(function(){
		$('.par').next().toggle();
	
        $('.subMenuBtn').bind( "click", function(e) {
            var elem = $(this);				
            elem.next().toggle();
        });

        $("div.menuListItem").click(function(){
            // console.log($(this).attr("href"));
            if($(this).attr("href") !== undefined){
                window.location = $(this).attr("href");
                return false;
            }
        });

        $.backstretch([
            <?php 
            $i = 0;
            $bgCount = count($this->bgList);
            if($bgCount > 0):
                foreach ($this->bgList as $bgItem):
                    ++$i;
            ?>
                "<?= Yii::app()->baseUrl ?>/images/uploaded/original/<?= $bgItem ?>"<?php if($i != $bgCount):?>,<?php endif; ?>
            <?php 
                endforeach;
            endif;
            ?>
        ], {duration: 10000, fade: 750});
    });
</script>
</body>
</html>
