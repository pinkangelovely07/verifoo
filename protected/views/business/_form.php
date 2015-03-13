<?php
/* @var $this BusinessController */
/* @var $model Business */
/* @var $form CActiveForm */
?>

<div class="form">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php if(isset($model->logo) && $model->logo!=''){ ?>
	<div class="row">
		<?php
			$this->widget('ext.SAImageDisplayer', array(
					    'image' => $model->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.png',
					    'title'=>ucwords($model->businessname),
					)); 
		?>
    </div>
    <?php  } ?>
    
	<div class="row">
        <?php echo $form->labelEx($model,'logo'); ?>
        <?php echo CHtml::activeFileField($model, 'logo'); ?>  
        <?php echo $form->error($model,'logo'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'businessname'); ?>
		<?php echo $form->textField($model,'businessname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'businessname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>120,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>120,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
	</div>
<div class="row">
		<?php echo $form->labelEx($profile,'phonenumber'); ?>
		<?php echo $form->textField($profile,'phonenumber',array('size'=>120,'maxlength'=>255)); ?>
		<?php echo $form->error($profile,'phonenumber'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($profile,'website'); ?>
		<?php echo $form->textField($profile,'website',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($profile,'website'); ?>
	</div>

	
	<div class="row">
		
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description', array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'openschedule'); ?>
		<?php echo $form->textField($profile,'openschedule',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($profile,'openschedule'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'foundeddate'); ?>
		
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			    'name'=>'Businessprofile[foundeddate]',
			    // additional javascript options for the date picker plugin
			     'value'=>$profile->foundeddate,
			    'options'=>array(
			    	'changeMonth'=>true,
        			'changeYear'=>true,
			        'showAnim'=>'fold',
			         'dateFormat' => 'yy-mm-dd',
			         'maxDate' => date("Y-m-d"),
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;'
			    ),
			));
		?>
		<?php echo $form->error($profile,'foundeddate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($profile,'facebook_page'); ?>
		<?php //echo $form->textField($model,'facebook_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[facebook_page]',  $profile->facebook_page,
    		array('prepend' => 'https://www.facebook.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'facebook_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'twitter_page'); ?>
		<?php //echo $form->textField($model,'twitter_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[twitter_page]', $profile->twitter_page,
    		array('prepend' => 'https://twitter.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'twitter_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'gplus_page'); ?>
		<?php //echo $form->textField($model,'gplus_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[gplus_page]', $profile->gplus_page,
    		array('prepend' => 'https://plus.google.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'gplus_page'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
	</div>
	<div class="rowCategory">
	
	<?php
		//$model->category= array("Apparel & Jewelry","Automotive");
		echo $form->checkBoxList($model, 'category', $category);
		/*foreach($category as $cat)
		{
			 echo TbHtml::checkBox('category[]', false, array('label' => $cat));
		}*/
	?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->