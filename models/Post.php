<?php

/**
 * This is the model class for table "Post".
 *
 */
class Post extends ActiveRecord
{

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
