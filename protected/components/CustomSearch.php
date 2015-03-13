<?php
class CustomSearch{
	
	public static function searchControl($biscuit, $except=0){
		
				$bnameSQL = array();
			    $bcategorySQL = array();
			    $bdescriptionSQL = array();
				$baddressSQL = array();
				//weights 
				$scoreName = 4;
				$scoreCategory = 3;
				$scoreAddress = 1;
				$scoreDescription = 1;
				$escKey = trim(addslashes($biscuit));
				$keywords = CustomTool::filterSearchKeys($escKey);
				
				if(count($keywords)>0){
					$bnameSQL[] = "if (businessname LIKE '%".$escKey."%',{$scoreName},0)";
					$bcategorySQL[] = "if (category LIKE '%".$escKey."%',{$scoreCategory},0)";
					$baddressSQL[] = "if (address LIKE '%".$escKey."%',{$scoreAddress},0)";
				    $bdescriptionSQL[] = "if (description LIKE '%".$escKey."%',{$scoreDescription},0)";
				}
				
				if (count($keywords) >= 1){
					
					foreach($keywords as $key){
					    $bnameSQL[] = "if (businessname LIKE '%".$key."%',{$scoreName},0)";
					    $bcategorySQL[] = "if (category LIKE '%".$key."%',{$scoreCategory},0)";
						$baddressSQL[] = "if (address LIKE '%".$escKey."%',{$scoreAddress},0)";
					    $bdescriptionSQL[] = "if (description LIKE '%".$key."%',{$scoreDescription},0)";
					   // $urlSQL[] = "if (slug LIKE '%".$key."%',{$scoreUrlKeyword},0)";
					   
					}
				}
				
					$businesses=new CActiveDataProvider('Business', array(
					    'criteria'=>array(
					    		
					    		'select'=> "id,businessname,datecreated,category,
							            description,logo,user_id,
							            (
							                (
							                ".implode(" + ", $bnameSQL)."
							                )+
							                (
							                ".implode(" + ", $bdescriptionSQL)."
							                )+
							                (
							                ".implode(" + ", $baddressSQL)."
							                )+
							                (
							                ".implode(" + ", $bcategorySQL)."
							                )
							            ) as relevance",
							    'condition'=>'id!='.$except.' AND status>=0',
					    		'params'=>array(':searchname'=>'%'.$biscuit.'%'),
					    		'alias'=>'business',
					    		'having'=>'relevance>0',
					    		'order' => 'relevance DESC',
					    		//'with' => array('businessprofile'),
					    ),
					  /* 	'sort' =>
						        array
						        (
						                'defaultOrder' => array('relevance'=>true),
						                'attributes' => 
						                        array(
						                                'relevance'=>
						                                        array(
						                                                'asc'=>'relevance DESC',
						                                                'desc'=>'relevance DESC',
						                                        ),
						                        ),
						        ),*/
					    'pagination'=>array('pageSize'=>'2'),
					));
					
				return $businesses;
	}
	
	public static function limitChars($query, $limit = 200){
    return substr($query, 0,$limit);
}
}
