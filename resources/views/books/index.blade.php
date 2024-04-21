@extends('books.layout.app')
@section('content')

    <h1 class="mb-5 text-2xl">Books</h1>



    <form action="{{ route('books.index') }}" method="GET" class="mb-4 flex space-x-2">
        <input type="text" name="title" id="" class="input" placeholder="Search by title" value=" {{ request('title') }} ">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button type="submit" class="btn">Search</button>
        <a href="{{route('books.index')}}" class="btn">Clear</a>
    </form>
    <div class="filter-container mb-4 flex">
        @php
            $filters =
            [
                '' => 'Larest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Month',
                'highest_rated_last_month' => 'Highest Rated Last month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 month'
            ];
        @endphp

        @foreach ($filters as $key => $lable )
            <a href="{{ route('books.index',[...request()->query(),'filter' => $key ]) }}" class=" {{ request('filter') === $key || ( request('filter') === null && $key === '' ) ? 'filter-item-active' : 'filter-item' }} ">
                {{$lable}}
            </a>
        @endforeach
    </div>

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
                        <x-star-rating :rating="$book->reviews_avg_rating"/>
                    </div>
                    <div class="book-review-count">
                        out {{$book->reviews_count}} {{ Str::plural('Review', $book->reviews_count) }}
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
    @if ($books->count())

    <nav class=" mt-4 ">{{ $books->links() }}</nav>

@endif


@endsection
