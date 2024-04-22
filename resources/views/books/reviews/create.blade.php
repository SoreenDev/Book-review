@extends('books.layout.app')
@section('content')
 <h1 class="mb-10 text-2xl ">Add Review for {{$book->title}} </h1>
 <form action="{{ route('books.reviews.store',['book'=> $book]) }}" method="POST">
    @csrf
    <label for="review">Review</label>
    <textarea name="review" id="review" required class="input mb-4"></textarea>
    <label for="review">Rating</label>
    <select name="rating" id="rating" requierd class="input mb-4">
        <option value="">Select Rating</option>
        @for ($i = 1;$i<=5;$i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>
    <button type="submit" class="btn">Add Review</button>
</form>
@endsection