<?php

namespace App\Transformers;

use App\Author;
use App\Transformers\BaseTransformer;

class AuthorTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'authors'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Author $author)
    {
        $request = \Request::instance();
        $fields = $request->input('fields.author', null);

        $data =  [
            'id'                => $author->id,
            'name'              => $author->name,
            'gender'            => $author->gender,
            'biography'         => $author->biography,
            'created_at'        => $author->created_at->toIso8601String(),
            'updated_at'        => $author->updated_at->toIso8601String(),
        ];

        if (is_null($fields)) {
            return $data;
        }

        $fields = explode(',', $fields);
        $fields[] = 'id';

        return array_intersect_key($data, array_flip($fields));
    }
}
