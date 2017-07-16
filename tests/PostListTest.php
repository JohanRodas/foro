<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostListTest extends FeatureTestCase
{
    public function test_a_user_can_see_the_post_list_and_go_to_the_details()
    {
        $post = $this->createPost([
        	'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?',
        ]);

        $this->visit('/')
	        ->seeInElement('h1', 'Post')
	        ->see($post->title)
	        ->click($post->title)
	        ->seePageIs($post->url);
    }

	public function test_a_user_can_see_the_post_list_pagination() {
		$post1 = $this->createPost([
			'title' => 'Este es el post 1',
		]);

		$post2 = $this->createPost([
			'title' => 'Este es el post 2',
		]);

		$post3 = $this->createPost([
			'title' => 'Este es el post 3',
		]);

		$post4 = $this->createPost([
			'title' => 'Este es el post 4',
		]);

		$this->visit('/')
		     ->seeInElement('h1', 'Post')
		     ->see($post1->title)
		     ->click($post1->title)
		     ->seePageIs($post1->url);

		$this->visit('/?page=2')
		     ->seeInElement('h1', 'Post')
		     ->see($post3->title)
		     ->click($post3->title)
		     ->seePageIs($post3->url);;
    }
}
