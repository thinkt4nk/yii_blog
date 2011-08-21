<?php
/**
 * BlogModule class file.
 *
 * @author Ryan Bales <thinkt4nk@gmail.com>
 */
Yii::import('application.modules.blog.models.Post');
Yii::import('application.modules.blog.models.Comment');
Yii::import('application.modules.blog.models.Tag');
Yii::import('application.modules.blog.models.PostTag');
/**
 * With the above configuration, you will be able to access BlogModule in your browser using
 * the following URL:
 *
 * http://localhost/path/to/index.php?r=blog
 *
 * If your application is using path-format URLs with some customized URL rules, you may need to add
 * the following URLs in your application configuration in order to access GiiModule:
 * <pre>
 * 'components'=>array(
 *     'urlManager'=>array(
 *         'urlFormat'=>'path',
 *         'rules'=>array(
 *             'blog'=>'blog',
 *             'blog/<controller:\w+>'=>'blog/<controller>',
 *             'blog/<controller:\w+>/<action:\w+>'=>'blog/<controller>/<action>',
 *             ...other rules...
 *         ),
 *     )
 * )
 * </pre>
 *
 * You can then access BlogModule via:
 *
 * http://localhost/path/to/index.php/blog
 */
class BlogModule extends CWebModule
{
	public $defaultController = 'Post';
	/**
	 * Initializes the blog module.
	 */
	public function init()
	{
		/*
		parent::init();
		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'class'=>'CErrorHandler',
				'errorAction'=>$this->getId().'/default/error',
			),
			'user'=>array(
				'class'=>'CWebUser',
				'stateKeyPrefix'=>'gii',
				'loginUrl'=>Yii::app()->createUrl($this->getId().'/default/login'),
			),
		), false);
		$this->generatorPaths[]='gii.generators';
		$this->controllerMap=$this->findGenerators();
		*/
	}
	/**
	 * Performs access check to gii.
	 * This method will check to see if user IP and password are correct if they attempt
	 * to access actions other than "default/login" and "default/error".
	 * @param CController $controller the controller to be accessed.
	 * @param CAction $action the action to be accessed.
	 * @return boolean whether the action should be executed.
	 */
	 /*
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$route=$controller->id.'/'.$action->id;
			if(!$this->allowIp(Yii::app()->request->userHostAddress) && $route!=='default/error')
				throw new CHttpException(403,"You are not allowed to access this page.");

			$publicPages=array(
				'default/login',
				'default/error',
			);
			if($this->password!==false && Yii::app()->user->isGuest && !in_array($route,$publicPages))
				Yii::app()->user->loginRequired();
			else
				return true;
		}
		return false;
	}
	*/
}
