<?php
/* @var $this ArticleCrudController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_parent_id'); ?>
		<?php echo $form->textField($model,'article_parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_language_id'); ?>
		<?php echo $form->textField($model,'article_language_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_desc'); ?>
		<?php echo $form->textField($model,'article_desc',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_keywords'); ?>
		<?php echo $form->textField($model,'article_keywords',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_title'); ?>
		<?php echo $form->textField($model,'article_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_text'); ?>
		<?php echo $form->textArea($model,'article_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_seq'); ?>
		<?php echo $form->textField($model,'article_seq'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_just_parent'); ?>
		<?php echo $form->textField($model,'is_just_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_just_link'); ?>
		<?php echo $form->textField($model,'is_just_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_status'); ?>
		<?php echo $form->textField($model,'article_status',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->