
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?= Yii::t('user','Fields with ') ?><span class="required">*</span><?= Yii::t('user',' are required.') ?></p>

	<div class="row">
		<?php echo $form->labelEx($model,'email',array('label' => Yii::t('user','email'))); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password',array('label' => Yii::t('user','password'))); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton(Yii::t('user','login'),Yii::app()->createUrl('user/login'),array('replace' => '#loginUser'),array('name' => 'loginSubmit')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
