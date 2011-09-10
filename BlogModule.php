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
class BlogModule extends CWebModule
{
	public $defaultController = 'Post';

	/**
	 * Initializes the blog module.
	 */
	public function init()
	{
		parent::init();
		/*
		Yii::app()->setComponents(array(

		));
		*/
	}
}
