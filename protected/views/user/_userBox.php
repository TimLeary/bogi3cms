<div class="span-3"><?= CHtml::ajaxLink(Yii::t('user','logout'), Yii::app()->createUrl('user/logout'),array(),array('name'=>'logout')) ?></div>
<div class="span-3 last"><?= CHtml::ajaxLink(Yii::t('user','changePass'), Yii::app()->createUrl('user/changePassword'),array(),array('name'=>'changePass')) ?></div>
<div class="clear"></div>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'changePassBox',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=> Yii::t('user','changePass'),
            'autoOpen'=>false,
        ),
    ));
    ?>
    <div id='changePassword'>
        <?php $this->renderPartial('_changePassword', array('model'=>$changePass)); ?>
    </div>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>