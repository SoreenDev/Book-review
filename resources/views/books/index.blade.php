@extends('books.layout.app')
@section('content')

    <form action="{{ route('books.index') }}" method="GET" class="mb-4 flex space-x-2">
        <input type="text" name="title" id="" class="input" placeholder="Search by title" value=" {{ request('title') }} ">
        <button type="submit" class="btn">Search</button>
        <a href="{{route('books.index')}}" class="btn">Clear</a>
    </form>

    <h1 class="mb-10 text-2x1">Books</h1>
    <ul>

        @forelse ($books as $book )
            <li class="mb-4">
                <div class="book-item">
                <div
                    class="flex flex-wrap items-center justify-between">
                    <div class="w-full flex-grow sm:w-auto">
                    <a href="{{ route('books.show', $book) }}" class="book-title">{{$book->title}}</a>
                    <span class="book-author">by {{$book->author}}</span>
                    </div>
                    <div>
                    <div class="book-rating">
                        {{ number_format($book->reviews_avg_rating,1) }}
                    </div>
                    <div class="book-review-count">
                        out {{$book->reviews_count}}{{ Str::plural('Review', $book->reviews_count) }}
                    </div>
                    </div>
                </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                <p class="empty-text">No books found</p>
                <a href=" {{ route('books.index') }} " class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>

@endsection
