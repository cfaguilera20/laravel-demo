<?php

namespace App\Transformers;

use App\Book;
use App\Transformers\BaseTransformer;

class BookTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'author'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Book $book)
    {
        $request = \Request::instance();
        $fields = $request->input('fields.book', null);

        $data =  [
            'id'                => $book->id,
            'author_id'         => $book->author_id,
            'title'             => $book->title,
            'description'       => $book->description,
            'created_at'        => $book->created_at->toIso8601String(),
            'updated_at'        => $book->updated_at->toIso8601String(),
        ];

        if (is_null($fields)) {
            return $data;
        }

        $fields = explode(',', $fields);
        $fields[] = 'id';

        return array_intersect_key($data, array_flip($fields));
    }
}
