@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <p class="mb-2">
                        Categories: <br/>
                        @foreach ($categories as $id => $category)
                            <div class="badge{{ isset($selectedCategories[$id]) ? ' badge-warning text-white' : '' }}"
                                @if (isset($selectedCategories[$id]))
                                    onclick='window.location.href = "{!! route('frontend.posts.index', ['categories' => array_diff_key($selectedCategories, [$id => 1])]) !!}"'
                                @else
                                    onclick='window.location.href = "{!! route('frontend.posts.index', ['categories' => $selectedCategories + [$id => 1]]) !!}"'
                                @endif
                            >
                                {{ $category }}
                            </div>
                        @endforeach
                    </p>
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-12 mb-4">
                                <div class="float-left mt-2 mr-2">
                                    @forelse($post->categories as $category)
                                        <span class="h4 mr-1 text-white bg-warning rounded p-1">{{ $category->name }}</span>
                                    @empty
                                        <span class="h4 mr-1 text-white bg-warning rounded p-1">All</span>
                                    @endforelse
                                </div>
                                <span style="color: darkgreen;">
                                    {{ $post->title }}<br/>
                                    {{ $post->start_date }}
                                </span>
                                <p>
                                    @if (strlen(strip_tags($post->post_text)) > 100)
                                        {{ Str::limit(strip_tags($post->post_text), 100) }}
                                    @else
                                        {!! $post->post_text !!}
                                    @endif
                                </p>
                                <p>
                                    <a href="{{ route('frontend.posts.show', $post) }}">Read more</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px;" class="row d-none d-sm-block">
                <div class="col-lg-12">
                    <a class="btn btn-warning text-white" href="{{ url()->current() }}">
                        Reload
                    </a>
                    @can('post_create')
                        <a class="btn btn-primary" href="{{ route('frontend.posts.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<footer class="footer d-block d-sm-none">
    <div class="row">
        <div class="col">
            <a class="btn btn-warning text-white btn-block" href="{{ url()->full() }}">Reload</a>
        </div>
        @can ('post_create')
            <div class="col">
                <a class="btn btn-primary btn-block" href="{{ route('frontend.posts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
                </a>
            </div>
        @endcan
    </div>
</footer>
@endsection
@section('styles')
<style>
    .badge {
        font-size: 16px;
        cursor: pointer;
    }
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 40px;
        line-height: 40px;
        background-color: #f5f5f5;
    }
</style>
@endsection