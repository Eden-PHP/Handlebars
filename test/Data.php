<?php //-->
/**
 * This file is part of the Eden PHP Library.
 * (c) 2014-2016 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
class Eden_Handlebars_Data_Test extends PHPUnit_Framework_TestCase
{
	public function testFind()
	{
		$data = Eden\Handlebars\Data::i(array(
			'product_id' => 123,
			'product_title' => 'Hello World',
			'product_comments' => array(
				'comment1' => 'this is good',
				'comment2' => 'this is great',
				'comment3' => 'this is nice'
			)
		));
		
		$this->assertInstanceOf('Eden\\Handlebars\\Data', $data);
		$this->assertEquals(123, $data->find('product_id'));
		$this->assertEquals('Hello World', $data->find('product_title'));
		$this->assertEquals('this is good', $data->find('product_comments.comment1'));
		$this->assertEquals('this is great', $data->find('product_comments.comment2'));
		$this->assertEquals('this is nice', $data->find('product_comments.comment3'));
	}

	public function testGet()
	{
		$data = Eden\Handlebars\Data::i(array(
			'product_id' => 123,
			'product_title' => 'Hello World',
			'product_comments' => array(
				'comment1' => 'this is good',
				'comment2' => 'this is great',
				'comment3' => 'this is nice'
			)
		))->get();
		
		$this->assertTrue(is_array($data));
		$this->assertEquals(123, $data['product_id']);
		$this->assertEquals('Hello World', $data['product_title']);
		$this->assertEquals('this is good', $data['product_comments']['comment1']);
		$this->assertEquals('this is great', $data['product_comments']['comment2']);
		$this->assertEquals('this is nice', $data['product_comments']['comment3']);
	}
	
	public function testPush()
	{
		$data = Eden\Handlebars\Data::i(array(
			'product_id' => 123,
			'product_title' => 'Hello World',
			'product_comments' => array(
				'comment1' => 'this is good',
				'comment2' => 'this is great',
				'comment3' => 'this is nice'
			)
		))
		->push(array(
			'comment1' => 'this is good',
			'comment2' => 'this is great',
			'comment3' => 'this is nice'
		))
		->push(array(
			'comment4' => 'this is cool',
			'comment5' => 'this is awesome',
			'comment6' => 'this is epic'
		));
		
		$this->assertInstanceOf('Eden\\Handlebars\\Data', $data);
		$this->assertEquals('Hello World', $data->find('../../product_title'));
		$this->assertEquals('this is good', $data->find('../comment1'));
		$this->assertEquals('this is great', $data->find('../../product_comments.comment2'));
		$this->assertEquals('this is epic', $data->find('comment6'));
		
		$this->assertEquals('Hello World', $data->find('.././../product_title'));
		$this->assertEquals('this is good', $data->find('./../comment1'));
		$this->assertEquals('this is great', $data->find('../.././product_comments.comment2'));
		$this->assertEquals('this is epic', $data->find('./comment6'));	
	}

	public function testPop()
	{
		$data = Eden\Handlebars\Data::i(array(
			'product_id' => 123,
			'product_title' => 'Hello World',
			'product_comments' => array(
				'comment1' => 'this is good',
				'comment2' => 'this is great',
				'comment3' => 'this is nice'
			)
		))
		->push(array(
			'comment1' => 'this is good',
			'comment2' => 'this is great',
			'comment3' => 'this is nice'
		))
		->push(array(
			'comment4' => 'this is cool',
			'comment5' => 'this is awesome',
			'comment6' => 'this is epic'
		))
		->pop();
		
		$this->assertInstanceOf('Eden\\Handlebars\\Data', $data);
		$this->assertEquals('Hello World', $data->find('../product_title'));
		$this->assertEquals('this is good', $data->find('comment1'));
		$this->assertEquals('this is great', $data->find('../product_comments.comment2'));
		
		$this->assertEquals('Hello World', $data->find('./../product_title'));
		$this->assertEquals('this is good', $data->find('./comment1'));
		$this->assertEquals('this is great', $data->find('.././product_comments.comment2'));
	}

	
}