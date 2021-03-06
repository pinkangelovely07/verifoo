<?php

class BusinessController extends Controller
{
	
	public $layout='//layouts/businesslayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','search'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updatelogo'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($baseUrl.'/css/business.css');
		$cs->registerScriptFile('/js/jquery.rating.js'); 
		
		$reviewModel = new Review;
		$bmodel = $this->loadModel($id);
		if(isset($_POST['Review']))
		{
			$reviewModel->attributes=$_POST['Review'];
			$reviewModel->date_review = date("Y-m-d H:i:s");
			$reviewModel->reviewer_id = Yii::app()->user->id;
			$reviewModel->business_id = $bmodel->id; 
			if($reviewModel->validate())
			{
				if($reviewModel->save())
					Yii::app()->user->setFlash('rated','Thank you for rating '.ucwords($bmodel->businessname));
				
			}
		}
		$reviews=new CActiveDataProvider('Review', array(
		    'criteria'=>array('condition'=>'business_id='.$bmodel->id,
		    'alias'=>'review',
		    'with'=>array('user'=>array('alias'=>'user','with'=>array('profile'=>array('alias'=>'profile')))),
		    'order' => 'review.id DESC',
		    ),
		    'pagination'=>array('pageSize'=>'5'),
		));	
		$this->render('view',array(
			'model'=>$bmodel,'reviewmodel'=>$reviewModel,'profile'=>$bmodel->businessprofile,
			'reviews'=>$reviews,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Business;
		$profile = new Businessprofile;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Business']))
		{
			$model->attributes=$_POST['Business'];
			$profile->attributes=$_POST['Businessprofile'];
			$model->user_id = Yii::app()->user->id;
			$model->views = 0;
			$model->dti_verified = 0;
			$model->datecreated = date("Y-m-d H:i:s");
			if($model->category!='')
				$model->category = implode(':',$model->category);
			
			$oldfilename = $model->logo;
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {
		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
				
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }
				
		    }   
		    
			if($model->save()){
				$profile->business_id=$model->id;
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$ct = new CustomTool;
		$category = $ct->getCategoryList();
		$this->render('create',array(
			'model'=>$model, 
			'profile'=>$profile,'category'=>$category
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatelogo($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Business']))
		{
			
			$oldfilename = $model->logo;
			$model=$this->loadModel($id);
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {

		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
					
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }

		    }   
		}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		
	} 
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);
		$profile=$model->businessprofile;
		$this->performAjaxValidation(array($model,$profile));
		if(!CustomTool::isBusinessOwner($model->user_id))
			$this->redirect(array('business/view','id'=>$model->id));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Business']))
		{
			
			$oldfilename = $model->logo;
			$model->attributes=$_POST['Business'];
			$profile->attributes=$_POST['Businessprofile'];
			if($model->category!='')
				$model->category = implode(':',$model->category);
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {

		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
					
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }

		    }   

			if($model->save()){
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		if($model->category!=null)
		{
			$model->category = explode(':',$model->category);
		}
		$ct = new CustomTool;
		$category = $ct->getCategoryList();
		$this->render('update',array(
			'model'=>$model,'profile'=>$profile, 'category'=>$category
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Business');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionSearch()
	{
		
		$businesses = null;
		$biscuit = null;
		if(isset($_GET['searchname']))
		{
			
			if(isset($_GET['searchname']) && $_GET['searchname']!=''){
				$biscuit = $_GET['searchname'];
				//CustomCookie::putInAJar($biscuit,5);//5 = number of key search stored
				
				$searchCtrl = new SearchController();
				$businesses = $searchCtrl->search($biscuit);
				print_r($businesses);exit;
			}
		    /*
		    $businesses=new CActiveDataProvider('Business',array(
						'criteria' => array(
						'order' => 'id DESC',
						'condition'=>'businessname LIKE :match',
						'params'    => array(':match' => "%$keyword%")
					),
					'pagination'=>array('pageSize'=>'32'),
					)
			);
		    */
		    
			$this->render('search',array('b_list'=>$businesses,'keyword'=>$biscuit));
		}
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Business('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Business']))
			$model->attributes=$_GET['Business'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Business the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Business::model()->with('businessprofile')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Business $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='business-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
