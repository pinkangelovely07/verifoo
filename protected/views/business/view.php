<?php
/* @var $this BusinessController */

?>
<div id="businessLCol">
		<div class="userprofile">
					<?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $model->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.jpg',
					)); ?>
			
			<?php 
				
				if($model->user_id==Yii::app()->user->id):
				
				$this->widget('bootstrap.widgets.TbModal', array(
			    'id' => 'tbmodal-form1',
			    'header' => 'Business Logo',
			    'content' => $this->renderPartial('_uploadLogo',array('picture'=>$model,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
			    'footer' => array(
			        TbHtml::button('Upload Image', array('onclick' => '$("#mainlayoutmodal-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
			        TbHtml::button('Close', array('data-dismiss' => 'modal')),
			     ),
			)); ?>
			 
				<?php echo TbHtml::button('Upload Business Logo', array(
				    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
				    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
				    'data-toggle' => 'modal',
				    'data-target' => '#tbmodal-form1',
				    'id'=>'mainlayoutUploadProfile',
				    'class' =>'btn btn-primary'
				)); 
			endif;
			
			?>
			
				
				
		</div>
		<div class="verticalMenu">
			
			
			<?php if(isset(Yii::app()->user->id)):
				echo '<h4 class="prepend-24">Businesses</h4>';
				$this->widget('application.components.BusinessMenu');
				endif;
			?>
				
				<?php $this->widget('zii.widgets.CMenu', array(
			    'items'=>array(
					array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Favorites"), 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Create Business', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Messages', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout ").'('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
			)); ?>
		</div>
		</div>
<div id="businessRCol">		
<h2><?php echo $model->businessname; 
		if(Yii::app()->user->id==$model->user_id){
	  	 echo"<span class='h2span'>
	  	 		<a href='".Yii::app()->createUrl('business/update', array('id' => $model->id))."'>( Edit Business )</a>
	  	 	</span>";
		}
	?>
	
<div class="socialsites">
	<?php if(isset($profile->facebook_page) && $profile->facebook_page!=''):?>
				<a href="https://www.facebook.com/<?php echo $profile->facebook_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/facebook_icon.png' ?>"></a>
	<?php endif;
	if(isset($profile->twitter_page) && $profile->twitter_page!=''):?>
			<a href="https://twitter.com/<?php echo $profile->twitter_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/twitter_icon.png' ?>"></a>
	<?php endif;
	 if(isset($profile->gplus_page) && $profile->gplus_page!=''):?>
			<a href="https://plus.google.com/<?php echo $profile->gplus_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/google_icon.png' ?>"></a>
	<?php endif;?>		
</div>	
</h2>

<div class="businessInfo">
	<p class="businessfield">Founded: <span class="lightblue"><?php echo date("M d, Y",strtotime($profile->foundeddate));?></span></p>
	<?php if($profile->dti_number!=''):?>
	<p class="businessfield">DTI No.: <span class="lightblue"><?php echo ucwords($profile->dti_number);?></span></p>
	<?php endif;?>
	<p class="businessfield">Open Schedule: <span class="lightblue"><?php echo ucwords($profile->openschedule);?></span></p>
	<?php if($profile->website!=''):?>
	<p class="businessfield">Website: <span class="lightblue"><?php echo ucwords($profile->website);?></span></p>
	<?php endif;?>
	<p class="businessfield">Contact #: <span class="lightblue"><?php echo $profile->phonenumber;?></span></p>
	
	<p class="businessfield">Views: <span class="lightblue"><?php echo $model->views;?></span></p>
	<p class="businessfieldBlock">Business Type: <span class="lightblue"><?php 
		$category = explode(":",$model->category);
	echo implode(", ",$category);	
	?></span></p>
	<p class="businessfieldBlock">Address: <span class="lightblue"><?php echo ucwords($model->address);?></span></p>
	<div class="businessDescription">
		<?php echo $model->description;?>
	</div>
</div>
<?php 
if(isset(Yii::app()->user->id)):
	if(Yii::app()->user->hasFlash('rated')): ?>
	
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('rated'); ?>
		</div>
	<?php else: 
			if(Yii::app()->user->id!= $model->user_id):
				$reviewmodel->reviewer_id = Yii::app()->user->id; 
				$reviewmodel->business_id = $model->id; 
				 $this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'tbmodal-reviewform',
				    'header' => 'Write a Review for '.ucwords($model->businessname),
				    'content' => $this->renderPartial('_reviewform',array('picture'=>$model,'reviewmodel'=>$reviewmodel,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				    	TbHtml::button('Submit Review', array('onclick' => '$("#mainlayoutreview-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				)); ?>
				 
				<?php echo TbHtml::button('Write a review for '.ucwords($model->businessname), array(
				    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
				    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
				    'data-toggle' => 'modal',
				    'data-target' => '#tbmodal-reviewform',
				    'id'=>'mainlayoutReviewForm',
				    'class' =>'btn btn-primary'
				));
			endif;
			
	endif;
endif;//end of if user is login
?>
<?php /*<script type="text/javascript">
 
function send()
 {
 
   var data=$("#review-form").serialize();
 	//var data = JSON.stringify(frm.serializeArray());
  $.ajax({
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl("business/sendreview"); ?>',
   data: data,
   dataType:'json',
	success:function(data){
                $("#review-form")[0].reset();
              },
   	error: function(data) { // if error occured
         alert("Error occured. Please try again");
    }
  });
 
}
 
</script> */?>
<div class="reviews">
	<h3>Reviews </h3>
	<?php 
				if($model->user_id!=Yii::app()->user->id)
					$emptyText = 'Be the first to write a review for '.ucwords($model->businessname);
				else
					$emptyText = 'You owned '.ucwords($model->businessname).'<br/>No reviews yet';
				
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$reviews,
					'itemView'=>'_reviewsRender',
					'id'=>"review_list",
					'enablePagination'=>true,
					'emptyText' => $emptyText,
					//'template'=>"{pager}\n{items}\n{pager}",
					'summaryText'=>'',
					//'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5), 
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.reviewlist', 
					        'listViewId'=>'review_list', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>12, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
			
		?>
</div>
</div>