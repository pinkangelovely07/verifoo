<?php 
 //$this->layout='//layouts/main';
?>
<div id="searchLCol">

<?php if(sizeof($b_list)>0):?>
<div class="searchBlist">
		<?php
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$b_list,
					'itemView'=>'_searchBlist',
					'id'=>'searchlist',
					'enablePagination'=>true,
					'viewData' => array('searchwords'=>$keyword),
					'summaryText'=>'',
					//'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5),
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.businesslist', 
					        'listViewId'=>'searchlist', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>2, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
		?>
		
</div>
<script>
	jQuery(function($) {
		jQuery('body').on('click','.businesslist',function(){
		 var data_id = $(this).attr("business-data");
		  	var siteDomain = document.domain;
		    var siteUrl = 'http://'+siteDomain;
		    var urllink = siteUrl+'/search/processcard'; 
		 /*var _exe = displayCard(data_id);
		 alert(_exe);*/
		 
	    /* $(".divavailability").html(_exe);*/
		   $.ajax({
	            	type: "GET",
	                url: urllink,
	                async: true,
	                data:data_id,
	                success: function(data) {
	                	alert("DATA:"+data);
	                }
	            });
		return false;
		});
});

function displayCard(data_id){
   
    var params = "data_id="+data_id;
    var result = $.ajax({type:"GET", url:urllink, async:false, dataType:"html", data:params}).responseText;
    return result;
}
</script>	
<?php endif;?>	
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
<div>
	<div class="cvBprofile">
					<?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $model->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.jpg',
					)); ?>
		</div>
	<div class="cvBdesc">
		<p class="businessfield">Founded: <span class="lightblue"><?php echo date("M d, Y",strtotime($profile->foundeddate));?></span></p>
		<?php if($profile->dti_number!=''):?>
		<p class="businessfield">DTI No.: <span class="lightblue"><?php echo ucwords($profile->dti_number);?></span></p>
		<?php endif;?>
		<p class="businessfield">Open Schedule: <span class="lightblue"><?php echo ucwords($profile->openschedule);?></span></p>
		<?php if($profile->website!=''):?>
		<p class="businessfield">Website: <span class="lightblue"><?php echo ucwords($profile->website);?></span></p>
		<?php endif;?>
		<p class="businessfield">Contact #: <span class="lightblue"><?php echo $profile->phonenumber;?></span></p>
		<p class="businessfieldBlock">Address: <span class="lightblue"><?php echo ucwords($model->address);?></span></p>
		
	</div>
	<div class="cvBDescription">
			<?php echo $model->description;?>
	</div>
	<div class="cvbD">
			<div id="business<?php  echo $model->id;?>" business-data="<?php  echo $model->id;?>" business-toggle="0" class="cvBButtons">Map</div>
			<div id="business<?php  echo $model->id;?>" business-data="<?php  echo $model->id;?>" business-toggle="0" class="cvBButtons">Photos</div>
			<div id="business<?php  echo $model->id;?>" business-data="<?php  echo $model->id;?>" business-toggle="0" class="cvBButtons">Reviews</div>
	</div>
	<?php if($model->category!=''):
			$category = explode(":", $model->category);
	?>
		<h4>Related to <?php echo ucfirst($model->businessname);?></h4>
		<ul class="related">
			<?php foreach($category as $cat):?>
			<li><a href="<?php echo Yii::app()->createUrl('search/index', array('searchname'=>strtolower($cat), 'except'=>$model->id))?>"><?php echo $cat;?></a></li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
</div>

</div>