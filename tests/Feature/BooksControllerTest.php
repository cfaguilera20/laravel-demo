<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{
    // use RefreshDatabase;

    /** @test **/
    public function index_status_code_should_be_200()
    {
        $response = $this->get('/api/books')->assertStatus(200);
    }

    /** @test **/
    public function index_should_return_a_collection_of_records()
    {
        $books = $this->bookFactory(2);
        $response = $this->get('/api/books');

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('links', $content);
        $this->assertArrayHasKey('self', $content['links']);
        $this->assertEquals(route('book.index'), $content['links']['self']);
        
        foreach ($books as $book) {
            $response->assertJsonFragment(
                [
                    'type'=> 'books',
                    'id'=> $book->id,
                    'attributes' =>[
                        'author_id' => $book->author_id,
                        'title' => $book->title,
                        'description' => $book->description,
                        'created_at' => $book->created_at->toIso8601String(),
                        'updated_at' => $book->updated_at->toIso8601String(),
                    ]
                ]
            );
        }
    }

    /** @test **/
    public function show_should_return_a_valid_book()
    {
        $book = $this->bookFactory();
        $response = $this->get("/api/books/{$book->id}")->assertStatus(200);

        // Get the response and assert the data key exists
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('links', $content);
        $this->assertArrayHasKey('self', $content['links']);
        $this->assertEquals(route('book.show', ['book' => $book->id]), $content['links']['self']);
        $data = $content['data'];

        $response->assertJsonFragment(
            [
                'type'=> 'books',
                'id'=> $book->id,
                'attributes' =>[
                    'author_id' => $book->author_id,
                    'title' => $book->title,
                    'description' => $book->description,
                    'created_at' => $book->created_at->toIso8601String(),
                    'updated_at' => $book->updated_at->toIso8601String(),
                ]
            ]
        );
    }

    /** @test **/
    public function show_should_fail_when_the_book_id_does_not_exist()
    {
        $this
            ->get('/api/books/99999', ['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'])
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'No query results for model [App\\Book] 99999'
            ]);
    }

    /** @test **/
    public function show_route_should_not_match_an_invalid_route()
    {
        $response = $this->get('/api/books/this-is-invalid');

        $this->assertNotRegExp(
            '/No query results for model/',
            $response->getContent(),
            'BooksController@show route matching when it should not.'
        );
    }

    /** @test **/
    public function store_should_save_new_book_in_the_database()
    {
        $author = factory(\App\Author::class)->create([
            'name' => 'H. G. Wells'
        ]);

        $formData = [
            'data' => [
                'type' => 'books',
                'attributes' => [
                    'title' => 'The Invisible Man',
                    'description' => 'An invisible man is trapped in the terror of his own creation',
                ]
            ]
        ];

        $response = $this->post(
            "api/authors/$author->id/books", 
            $formData, 
            ['Accept' => 'application/json']);

        $body = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('data', $body);
        

        $data = $body['data'];
        $attributes = $data['attributes'];

        $this->assertEquals('The Invisible Man', $attributes['title']);
        $this->assertEquals(
            'An invisible man is trapped in the terror of his own creation',
            $attributes['description']
        );
        $this->assertEquals($author->id, $attributes['author_id']);
        $this->assertTrue($data['id'] > 0, 'Expected a positive integer, but did not see one.');
        $this->assertDatabaseHas('books', ['title' => 'The Invisible Man']);
    }

    /** @test */
    public function store_should_respond_with_a_201_and_location_header_when_successful()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function update_should_only_change_fillable_fields()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function update_should_fail_with_an_invalid_id()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function update_should_not_match_an_invalid_route()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function destroy_should_remove_a_valid_book()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function destroy_should_return_a_404_with_an_invalid_id()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function destroy_should_not_match_an_invalid_route()
    {
        $this->markTestIncomplete('Pending test');
    }
}
