@extends('layouts.master')
@section('title', 'Категории')
    @section('content')

        @foreach($categories as $category)
            <div class="panel">
                <a href="{{route('category', $category->slug)}}">
                    <img src="{{\Illuminate\Support\Facades\Storage::url($category->image)}}">
                    <h2>{{$category->name}}</h2>
                </a>
                <p>
                    {{$category->description}}
                </p>
            </div>
        @endforeach
    @endsection
