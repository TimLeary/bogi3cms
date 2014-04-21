<?php
/* @var $this LanguageController */
/* @var $model Language */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'language_id'); ?>
		<?php echo $form->textField($model,'language_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'language_code'); ?>
		<?php echo $form->textField($model,'language_code',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'language_status'); ?>
		<?php echo $form->textField($model,'language_status',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->