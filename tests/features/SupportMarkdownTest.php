<?php

class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_content_support_markdown()
    {
        $importantText = 'Un texto importante';

        $post = $this->createPost([
            'content' => "La primera parte del texto. **$importantText**. La última parte del texto",
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }

    function test_xss_attack()
    {
        $xssAttack = "<script>alert('Malicius JS!')</script>";

        $post = $this->createPost([
            'content' => "$xssAttack. Texto normal.",
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal.')
            ->seeText($xssAttack);
    }

    function test_xss_attack_with_html()
    {
        $xssAttack = "<img src='img.jpg'>";

        $post = $this->createPost([
            'content' => "$xssAttack. Texto normal.",
        ]);

        $this->visit($post->url)
             ->dontSee($xssAttack);
    }
}
