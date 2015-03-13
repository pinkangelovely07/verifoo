
<div class="view sblist">
    <div class="bPics">
    	<a href="<?php echo Yii::app()->createUrl('search/checkview', array('id' => $data->id,'search'=>$searchwords));?>">
    	<?php $this->widget('ext.SAImageDisplayer', array(
		    'image' => $data->logo,
		    'size' => 'p160',
		    'group' => 'business',
		    'defaultImage' => 'default.jpg',
		    'title' => $data->businessname,
		)); ?>
		</a>
	</div>
	<div class="prepend-24 inline card-1">
		<div class="topDesc">
			<div class="bName"><h4><a href="<?php echo Yii::app()->createUrl('search/checkview', array('id' => $data->id,'search'=>$searchwords));?>"><?php echo $data->businessname;?></a></h4></div><div class="bstar">stars</div>
		</div>
		<div class="midDesc<?php echo $data->id;?>">
			
			
		</div>
		<div id="b<?php  echo $data->id;?>">
			<?php echo CHtml::encode($data->description,700); ?>
		</div>
		
		<?php
			echo CHtml::ajaxLink("View Map",array("getmap","id"=>$data->id,),array(
			 "beforeSend" => 'js:function(){}',
			 "success"=>'js:function(data){$.fn.yiiListView.update("incident_list",{});}',
			 "type"=>"post",
			
			  ),array("id"=>"businessControlMap".$data->id,"class"=>"businessControl","business-data"=>$data->id,"business-toggle"=>"0"  )); 
		?>
		<?php
			echo CHtml::ajaxLink("View Photo",array("getphotos","id"=>$data->id,),array(
			 "beforeSend" => 'js:function(){}',
			 "success"=>'js:function(data){$.fn.yiiListView.update("incident_list",{});}',
			 "type"=>"post",
			
			  ),array("id"=>"businessControlPhoto".$data->id,"class"=>"businessControl","business-data"=>$data->id,"business-toggle"=>"0" )); 
		?>
		<div id="businessControlReview<?php  echo $data->id;?>" business-data="<?php  echo $data->id;?>" business-toggle="0" class="businessControl">Review</div>
	</div>

</div>	