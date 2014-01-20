<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changePassword-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    <p class="note"><?= Yii::t('user','Fields with ') ?><span class="required">*</span><?= Yii::t('user',' are required.') ?></p>
    
    <div class="row">
            <?php echo $form->labelEx($model,'currentPassword',array('label' => Yii::t('user','password'))); ?>
            <?php echo $form->passwordField($model,'currentPassword'); ?>
            <?php echo $form->error($model,'currentPassword'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'newPassword',array('label' => Yii::t('user','newPassword'))); ?>
            <?php echo $form->passwordField($model,'newPassword'); ?>
            <?php echo $form->error($model,'newPassword'); ?>
    </div>
    <div class="row">
            <?php echo $form->labelEx($model,'newPassword_repeat',array('label' => Yii::t('user','newPassword_repeat'))); ?>
            <?php echo $form->passwordField($model,'newPassword_repeat'); ?>
            <?php echo $form->error($model,'newPassword_repeat'); ?>
    </div>
    
    <div class="row buttons">
            <?php echo CHtml::ajaxSubmitButton(Yii::t('user','change_password'),Yii::app()->createUrl('user/changePassword'),array('replace' => '#changePassword'),array('name' => 'changePasswordSubmit')); ?>
    </div>
    
    
<?php $this->endWidget(); ?>

</div><!-- form -->