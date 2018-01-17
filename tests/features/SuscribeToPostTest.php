<?php

use App\User;

class SuscribeToPostTest extends FeatureTestCase
{
    function test_a_user_can_subscribe_to_a_post()
    {
        // Having
        $post = $this->createPost();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // When
        $this->visit($post->url)
            ->press('Subscribirse al post');

        // Then
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url)
            ->dontSee('Subscribirse al post');
    }

    function test_a_user_can_unsubscribe_from_a_post()
    {
        // Having
        $post = $this->createPost();
        $user = factory(User::class)->create();

        $user->subscribeTo($post);

        $this->actingAs($user);

        // When
        $this->visit($post->url)
            ->dontSee('Subscribirse al post')
            ->press('Desuscribirse del post');

        $this->dontSeeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url);
    }
}