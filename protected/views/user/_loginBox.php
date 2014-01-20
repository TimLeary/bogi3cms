<div class="span-3"><?= CHtml::ajaxLink(Yii::t('user','login'), Yii::app()->createUrl('user/login'),array(),array('name'=>'login')) ?></div>
<div class="span-3 last"><?= CHtml::ajaxLink(Yii::t('user','registry'), Yii::app()->createUrl('user/register'),array(),array('name'=>'registry')) ?></div>
<div class="clear"></div>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'registerBox',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=> Yii::t('user','registry'),
            'autoOpen'=>false,
        ),
    ));
    ?>
    <div id='registerUser'>
        <?php $this->renderPartial('_registerform', array('model'=>$register)); ?>
    </div>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'loginformBox',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=> Yii::t('user','login'),
            'autoOpen'=>false,
        ),
    ));
    ?>
    <div id='loginUser'>
        <?php $this->renderPartial('_loginform', array('model'=>$login)); ?>
    </div>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>