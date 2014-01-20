<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?= Yii::t('user','Fields with ') ?><span class="required">*</span><?= Yii::t('user',' are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email',array('label' => Yii::t('user','email'))); ?>
		<?php echo $form->textField($model,'email',array('size'=>25,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'username',array('label' => Yii::t('user','username'))); ?>
		<?php echo $form->textField($model,'username',array('size'=>25,'maxlength'=>55)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'last_name',array('label' => Yii::t('user','last_name'))); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>25,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>
        
	<div class="row">
                <?php echo $form->labelEx($model,'first_name',array('label' => Yii::t('user','first_name'))); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>25,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'phone_num',array('label' => Yii::t('user','phone_num'))); ?>
		<?php echo $form->textField($model,'phone_num',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'phone_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city',array('label' => Yii::t('user','city'))); ?>
		<?php echo $form->textField($model,'city',array('size'=>25,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address',array('label' => Yii::t('user','address'))); ?>
		<?php echo $form->textField($model,'address',array('size'=>25,'maxlength'=>125)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'zip_code',array('label' => Yii::t('user','zip_code'))); ?>
		<?php echo $form->textField($model,'zip_code',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'zip_code'); ?>
	</div>
        
        <div class="row">
            <div class="agreeCheck">
                <?= CHtml::label(Yii::t('user','i_agree'),'agree')?>
                <?= CHtml::checkBox('agree',false,array('id'=>'agree'))?>
            </div>
            <!--<div class="agreeText"><?= CHtml::textArea('agreement',Yii::t('user','agreement_text'),array('disabled' => 'true','rows'=>5,'cols'=>40,'style'=>'width:240px;')) ?></div>-->
        </div>
            
	<div class="row buttons" id="registerButton" style="display:none">
            <?php echo CHtml::ajaxSubmitButton(Yii::t('user','register_it'),Yii::app()->createUrl('user/register'),array('replace' => '#registerUser'),array('name' => 'registerSubmit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $('#agree').click(function () {
        $("#registerButton").toggle(this.checked);
    });
</script>