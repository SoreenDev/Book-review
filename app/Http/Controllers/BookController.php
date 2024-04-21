<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter','');
        $books = Book::when($title , fn ($request ,$title) => $request->title($title));
        $books = match($filter){
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' =>  $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()->withReviewAvg()->withReviewCount()
        };

        $cachekey = 'books:'.$filter .':'.$title ;
        // $books = cache()->remember($cachekey, 3600, function () use($books) {
        //     return $books->get();
        // });
        $books = $books->paginate(7);
        return view('books.index', ['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cachekey = 'book:'. $id ;
        $book = cache()->remember($cachekey, 3600,fn ()
            =>Book::with(
            ['reviews' => fn($query) => $query->latest()]
        )->withReviewAvg()->withReviewCount()->findOrFail($id));
        return view('books.show',['book' =>$book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
