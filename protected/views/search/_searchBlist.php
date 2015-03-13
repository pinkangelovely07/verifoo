
<div class="view businesslist" id="bCard<?php echo $data->id;?>" business-data="<?php  echo $data->id;?>" >
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
	<div class="searchbDescription">
		<div class="topDesc">
			<div class="bName"><h6><a href="<?php echo Yii::app()->createUrl('search/checkview', array('id' => $data->id,'search'=>$searchwords));?>"><?php echo $data->businessname;?></a></h6></div>
			<div class="bstar">stars</div>
		</div>
		<div class="midDesc<?php echo $data->id;?>">
		</div>
		
	</div>
	

</div>	