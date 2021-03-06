<?php

/**
 * This is the model class for table "Post".
 *
 */
class Post extends ActiveRecord
{

	/* GETTERS */
	/**
	 * Get the text from the body of the post
	 */
	public function getBodyText()
	{
		return preg_replace('/<.*?>/','',$this->body);
	}
	/**
	 * Get the image data from the body of the post
	 */
	public function getImages()
	{
		$images = array();

		preg_match_all('/<img.*?src=\".*?".*?>/',$this->body,$image_tags);
		foreach ($image_tags[0] as $image_tag)
		{
			$images[] = preg_replace('/<img.*?src=\"(.*?)".*?>/','$1',$image_tag);
		}
		return $images;
	}
	/**
	 * Gets the published posts, grouped by year, month, day
	 *
	 * @return Array the arrangement of blog posts
	 */
	public static function getModelsArrangedByDate()
	{
		$ordered_posts = array();
		$posts = self::model()->scopePublished()->orderByDate()->findAll();
		foreach ($posts as $post)
		{
			$date_time = strtotime($post->date_posted);
			$year = date('Y',$date_time);
			$month = (int) date('m',$date_time);
			if (!isset($ordered_posts[$year])) {
				$ordered_posts[$year] = array();
				if (!isset($ordered_posts[$year][$month])) {
					$ordered_posts[$year][$month] = array();
				}
			}
			$ordered_posts[$year][$month][] = $post;
		}
		return $ordered_posts;
	}


	/* SCOPES */
	/**
	 * Scopes only published posts
	 *
	 * @return Post the scoped post AR object
	 */
	public function scopePublished()
	{
		$merge_criteria = new CDbCriteria(array(
			'condition' => 'published = 1'
		));
		$this->getDbCriteria()->mergeWith($merge_criteria);
		return $this;
	}
	/**
	 * Orders the posts by date, desc
	 *
	 * @return Post the ordered post AR object
	 */
	public function orderByDate($order = 'ASC')
	{
		$merge_criteria = new CDbCriteria(array(
			'order' => sprintf('t.date_posted %s',$order)
		));
		$this->getDbCriteria()->mergeWith($merge_criteria);
		return $this;
	}

	/* HOOKS */
	public function beforeValidate()
	{
		if( $this->isNewRecord )
		{
			$this->date_posted = date('Y-m-d H:i:s');
		}
		// FUCK TINYMCE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!111111
		$this->body = str_replace("..//","../",$this->body);
		$this->body = str_replace("../","",$this->body);
		$this->body = str_replace("uploads/","/uploads/",$this->body);
		return parent::beforeValidate();
	}

	/* BASE */
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, body, date_posted', 'required'),
			array('title', 'length', 'max'=>255),
			array('published','safe'),
			array('id, title, body, published', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'body' => 'Body',
			'date_posted' => 'Date Posted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
