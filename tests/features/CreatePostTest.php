<?php


class CreatePostTest extends FeatureTestCase {

	public function test_a_user_create_a_post()
	{

		// Having
		$title = 'Esta es una pregunta';
		$content = 'Este es el contenido';

		// When
		$this->actingAs($user = $this->defaultUser())
			->visit(route('posts.create'))
			->type($title, 'title')
			->type($content, 'content')
			->press('Publicar');

		// Then
		$this->seeInDatabase('posts', [
			'title' => $title,
			'content' => $content,
			'pending' => true,
			'user_id' => $user->id,
		]);


		// Test a user is redirect to the post details after creating it.
		$this->see($title);


	}

	public function test_creating_a_post_requires_authentication() {
		$this->visit(route('posts.create'))
			->seePageIs(route('login'));
		
	}

}