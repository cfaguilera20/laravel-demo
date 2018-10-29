<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Transformers\AuthorTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transformer = new AuthorTransformer();
        $authors = Author::with($transformer->getEagerLoads($request))->get();
        $data = fractal()
        ->collection($authors)
        ->transformWith($transformer)
        ->withResourceName('authors')
        ->toArray();

        // Set link
        $data['links']['self'] = route('author.index');

        // Response
        return response()->json($data, 200, [
            'Content-Type' => 'application/vnd.api+json'
        ], JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
