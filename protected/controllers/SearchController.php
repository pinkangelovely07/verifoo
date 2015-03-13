<?php

class SearchController extends Controller
{
	public $layout='//layouts/searchlayout';
	
	public function actionIndex()
	{
		
		$businesses = null;
		$biscuit = null;
		$searchkeywords = null;
		$except = 0;
		$recommend = '';
		if(isset($_GET['searchname']) && $_GET['searchname']!='')
		{
			
				$biscuit = $_GET['searchname'];
				CustomCookie::putInAJar($biscuit,5);//5 = number of key search stored
				if(isset($_GET['except']))
					$except = $_GET['except'];
			  	$businesses = CustomSearch::searchControl($biscuit,$except);
				if(sizeof($businesses)==0 || $businesses->getTotalItemCount() ==0){
					$recommend = 'No result found but we recommend some businesses';
					$businesses=new CActiveDataProvider('Business', array(
					    'criteria'=>array(
					    		'alias'=>'business',
					    		'condition'=>'id!='.$except.' AND status>=0',
					    		'order' => 'business.datecreated DESC',
					    ),
					    'pagination'=>array('pageSize'=>'2'),
					));	
				}
			
		}else{
			$recommend = 'We recommend some businesses';
			$businesses=new CActiveDataProvider('Business', array(
				    'criteria'=>array(
				    		'alias'=>'business',
				    		'condition'=>'id!='.$except.' AND status>=0',
				    		'order' => 'business.datecreated DESC',
				    ),
				    'pagination'=>array('pageSize'=>'2'),
				));
		}
		$this->render('index',array('b_list'=>$businesses,'keyword'=>$biscuit,'recommend'=>$recommend));
	}
	public function actionCheckview($id)
	{
		
		$model = Business::model()->with('businessprofile')->findByPK($id);
		
		$businesses = array();
		$biscuit = null;	
		
		if(isset($_GET['search']) && $_GET['search']!=''){
			
				$biscuit = $_GET['search'];
			  	$businesses = CustomSearch::searchControl($biscuit,$model->id);
		}
		$this->render('checkview',array('b_list'=>$businesses,'keyword'=>$biscuit,'model'=>$model,'profile'=>$model->businessprofile));
	}
	public function actionProcesscard(){
		if(isset($_GET['data_id']) && $_GET['data_id']!='')
		{	
			$pID = trim($_GET['data_id']);
		  	$model=Business::model()->with('businessprofile')->findByPk($pID);
			if(is_object($model) && sizeof($model)>0)
			{
				$business = array(
				
				'bname' => $model->businessname,
				'description' => $model->description,
				'address' => $model->address,
				'category' => $model->category,
				'dti_verified' => $model->dti_verified,
				'logo' => $model->logo,
			);
				if(sizeof($model->businessprofile)>0)
				{
					$business = array(
						'openschedule' => $model->businessprofile->openschedule,
						'website' => $model->businessprofile->website,
						'dti_number' => $model->businessprofile->dti_number,
						'phonenumber' => $model->businessprofile->phonenumber,
					);
				
				}
				echo json_encode($business);
				
			}
			
		}
	}
	
}