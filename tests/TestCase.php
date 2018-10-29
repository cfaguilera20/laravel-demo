<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * See if the response has a header.
     *
     * @param $header
     * @return $this
     */
    public function seeHasHeader($header)
    {
        $this->assertTrue(
            $this->response->headers->has($header),
            "Response should have the header '{$header}' but does not."
        );

        return $this;
    }

    /**
     * Asserts that the response header matches a given regular expression
     *
     * @param $header
     * @param $regexp
     * @return $this
     */
    public function seeHeaderWithRegExp($header, $regexp)
    {
        $this
            ->seeHasHeader($header)
            ->assertRegExp(
                $regexp,
                $this->response->headers->get($header)
            );

        return $this;
    }

    /**
     * Convenience method for creating a book with an author
     *
     * @param int $count
     * @return mixed
     */
    protected function bookFactory($count = null)
    {
        $author = factory(\App\Author::class)->create();
        $books = factory(\App\Book::class, $count)->make();

        if ($count === null) {
            $books->author()->associate($author);
            $books->save();
        } else {
            $books->each(function ($book) use ($author) {
                $book->author()->associate($author);
                $book->save();
            });
        }

        return $books;
    }
}
