<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function index_status_code_should_be_200()
    {
        $response = $this->get('/api/authors')->assertStatus(200);
    }
}
