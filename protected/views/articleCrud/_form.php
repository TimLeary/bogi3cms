<?php
/* @var $this ArticleCrudController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'article_parent_id'); ?>
		<?php echo $form->textField($model,'article_parent_id'); ?>
		<?php echo $form->error($model,'article_parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_language_id'); ?>
		<?php echo $form->textField($model,'article_language_id'); ?>
		<?php echo $form->error($model,'article_language_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_desc'); ?>
		<?php echo $form->textField($model,'article_desc',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'article_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_keywords'); ?>
		<?php echo $form->textField($model,'article_keywords',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'article_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_title'); ?>
		<?php echo $form->textField($model,'article_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'article_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_text'); ?>
		<?php echo $form->textArea($model,'article_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'article_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_seq'); ?>
		<?php echo $form->textField($model,'article_seq'); ?>
		<?php echo $form->error($model,'article_seq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_just_parent'); ?>
		<?php echo $form->textField($model,'is_just_parent'); ?>
		<?php echo $form->error($model,'is_just_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_just_link'); ?>
		<?php echo $form->textField($model,'is_just_link'); ?>
		<?php echo $form->error($model,'is_just_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_status'); ?>
		<?php echo $form->textField($model,'article_status',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'article_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->