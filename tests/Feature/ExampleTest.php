<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;

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

    public function test_setup_database()
    {
        DB::statement("DROP TABLE IF EXISTS comment");
        DB::statement("CREATE TABLE comment(
            comment_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(60),
            parent_id INT UNSIGNED DEFAULT NULL,
            comment TEXT,
            FOREIGN KEY fk_parent(parent_id)
            REFERENCES comment(comment_id)   
            ON UPDATE CASCADE
            ON DELETE CASCADE);");
        DB::table('comment')->insert([
            ['name' => 'Gustavo', 'parent_id'=>null, 'comment' => 'Isso é um teste'],
            ['name' => 'Maria', 'parent_id' => 1, 'comment' => 'Isso é outro teste'],
            ['name' => 'Nome 1', 'parent_id' => null, 'comment' => 'Isso é outro teste1'],
            ['name' => 'Nome 2', 'parent_id' => 1, 'comment' => 'Isso é outro teste2'],
            ['name' => 'Nome 3', 'parent_id' => 2, 'comment' => 'Isso é outro teste3'],
            ['name' => 'Nome 4', 'parent_id' => 3, 'comment' => 'Isso é outro teste4'],
            ['name' => 'Nome 5', 'parent_id' => null, 'comment' => 'Isso é outro teste5']
            
        ]);
        $this->assertTrue(true);
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
