<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;

class WriteCommentTest extends FeatureTestCase
{
    public function test_a_user_can_write_a_comment()
    {
        Notification::fake();

        $post = $this->createPost();

        $user = $this->defaultUser();
        $this->actingAs($user)
	        ->visit($post->url)
	        ->type('Un comentario', 'comment')
	        ->press('Publicar comentario');

        $this->seeInDatabase('comments', [
        	'comment' => "Un comentario",
	        'user_id' => $user->id,
	        'post_id' => $post->id
        ]);

        $this->seePageIs($post->url);

    }

	public function test_write_a_comment_requires_authentication() {

		$post = $this->createPost();

		$this->visit($post->url)
			->type('Un comentario', 'comment')
			->press('Publicar comentario')
			->seePageIs(route('login'));
	}

	public function test_write_a_comment_form_validation() {
		$post = $this->createPost();
		$this->actingAs($this->defaultUser())
		     ->visit($post->url)
		     ->press('Publicar comentario')
		     ->seePageIs($post->url)
		     ->seeErrors([
			     'comment' => 'El campo comment es obligatorio',
		     ]);
	}
}
