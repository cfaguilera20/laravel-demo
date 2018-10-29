<?php

namespace App\Jobs;

use App\Author;
use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BookStore
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $author = null;
    protected $request = null;
    protected $response = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $request, Author $author)
    {
        $this->request = $request;
        $this->author = $author;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Book $book)
    {
        $this->response  = $book->create([
            'title' => $this->request['data']['attributes']['title'],
            'description' => $this->request['data']['attributes']['description'],
            'author_id' => $this->author->id
        ]);
    }

    /**
     * Returns the response
     *
     * @return Book
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        // Called when the job is failing...
    }
}
