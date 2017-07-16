<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
	use DatabaseTransactions;

    function test_a_slug_is_generated_and_saved_to_the_database()
    {

    	$post = $this->createPost([
		    'title' => 'Como instalar Laravel',
	    ]);

        $this->assertSame('como-instalar-laravel', $post->fresh()->slug);
    }

    function test_a_get_url_attribute_is_return_correctly(){
	    $user = $this->defaultUser();

	    $post = $this->createPost([
		    'title' => 'Como instalar Laravel',
	    ]);

	    $user->posts()->save($post);

	    $this->visit($post->url)
		    ->seePageIs(route('posts.show', [$post->id, $post->slug]));

    }
}
