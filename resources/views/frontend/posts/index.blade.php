@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
                </div>

                @livewire('posts')
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