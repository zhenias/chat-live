<?php

namespace Tests\Feature\Chat;

use Tests\TestCase;

class ChatMessageTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
