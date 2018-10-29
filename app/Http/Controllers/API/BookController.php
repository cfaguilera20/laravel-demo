<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transformer = new BookTransformer();
        $books = Book::with($transformer->getEagerLoads($request))->get();
        $data = fractal()
        ->collection($books)
        ->transformWith($transformer)
        ->withResourceName('books')
        ->toArray();

        // Set link
        $data['links']['self'] = route('book.index');

        // Response
        return response()->json($data, 200, [
            'Content-Type' => 'application/vnd.api+json'
        ], JSON_NUMERIC_CHECK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $transformer = new BookTransformer();
            $book = Book::with($transformer->getEagerLoads($request))->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->abort($status = 404, 'Book not found');
        }
        $data = fractal()
        ->item($book)
        ->transformWith($transformer)
        ->withResourceName('books')
        ->toArray();
        
        // Set link
        $data['links']['self'] = route('book.show', ['book' => $id]);

        // Response
        return response()->json($data, 200, [
            'Content-Type' => 'application/vnd.api+json'
        ], JSON_NUMERIC_CHECK);
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
