<div id="messegeBox">
<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
        <div id="messegeTitle"><?= Yii::t('site','all_commit_calculate') ?></div>
	<?php echo $form->errorSummary($model); ?>
        <div class="msgUserDatas">
            <div class="row">
                <div class="nameLabel"><?php echo $form->labelEx($model,'name',array('label' => Yii::t('site','name'))); ?></div>
                <div class="mailLabel"><?php echo $form->labelEx($model,'email'); ?></div>
            </div>
            <div class="row">
                <div class="nameInput"><?php echo $form->textField($model,'name'); ?><?php echo $form->error($model,'name'); ?></div>
                <div class="mailInput"><?php echo $form->textField($model,'email'); ?><?php echo $form->error($model,'email'); ?></div>
            </div>
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject',array('label' => Yii::t('site','subject'))); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body',array('label' => Yii::t('site','body'))); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php //echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint"><?= Yii::t('site','Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.')?></div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('site','Submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
</div>