<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertEquals(route('book.index'), $content['self']);
        
        foreach ($books as $book) {
            $response->assertJsonFragment(
                [
                    'type'=> 'books',
                    'id'=> $book->id,
                    'attributes' =>[
                        'author_id' => $book->author_id,
                        'title' => $book->title,
                        'description' => $book->description,
                        'created_at' => $book->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $book->updated_at->format('Y-m-d H:i:s'),
                    ]
                ]
            );
        }
    }

    /** @test **/
    public function show_should_return_a_valid_book()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function show_should_fail_when_the_book_id_does_not_exist()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function show_route_should_not_match_an_invalid_route()
    {
        $this->markTestIncomplete('Pending test');
    }

    /** @test **/
    public function store_should_save_new_book_in_the_database()
    {
        $this->markTestIncomplete('Pending test');
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
