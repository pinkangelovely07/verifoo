
<div class="reviewlist">
		<div class="reviewPhoto">
			<?php 
			 
			 
					$this->widget('ext.SAImageDisplayer', array(
					    'image' => $data->user['image'],
					    'size' => 'p128',
					    'group' => 'users',
					    'defaultImage' => 'default.jpg',
					)); 
					
				 ?>
		</div>
		<div class="reviewDescription">
			<div class="reviewerName">
				<?php echo($data->user['username']);?>
			</div>
			<div class="reviewPostedDate">Posted: <?php echo date("M d, Y H:i:s a",strtotime($data->date_review));?></div>
			<div class="reviewStars">
				<?php
					for($x=1;$x<=$data->rate;$x++)
					 echo '<div class="star"></div>';
				
				?>
			</div>
			<div id="review<?php  echo $data->id;?>" class="reviewComment">
				<?php echo $data->comment; ?>
			</div>
		</div>

</div>	