<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_api_request_get_comments()
    {
        $response = $this->getJson('/api/comments');
 
        $response
            ->assertStatus(200);
    }
    public function test_api_request_create_new_comment()
    {
        $response = $this->putJson('/api/comments/', ['name'=>'Teste', 'comment'=>'teste comment', 'parent_id'=>1]);
 
        $response
            ->assertStatus(200);
    }

    public function test_api_request_update_comment()
    {
        $response = $this->putJson('/api/comments/{id}/', ['name'=>'Teste', 'comment'=>'teste comment']);
 
        $response
            ->assertStatus(200);
    }

    public function test_api_request_delete_comment()
    {
        $response = $this->deleteJson('/api/comments/1');
 
        $response
            ->assertNoContent();
      // verify database
    }
}
