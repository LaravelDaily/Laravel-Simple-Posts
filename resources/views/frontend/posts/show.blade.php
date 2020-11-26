@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.post.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <div class="float-left mt-2 mr-2">
                                    @forelse($post->categories as $category)
                                        <span class="h4 mr-1 text-white bg-warning rounded p-1">{{ $category->name }}</span>
                                    @empty
                                        <span class="h4 mr-1 text-white bg-warning rounded p-1">ALL</span>
                                    @endforelse
                                </div>
                                <span style="color: darkgreen;">
                                {{ $post->title }}<br/>
                                {{ $post->start_date }}
                            </span>
                                <p>
                                    {!! $post->post_text !!}
                                </p>
                                @if($post->attachment)
                                    <p>
                                        Attachment: <br/>
                                        <a href="{{ $post->attachment->getUrl() }}" target="_blank">
                                            @if(Str::startsWith($post->attachment->mime_type, 'image'))
                                                <img src="{{ $post->attachment->getUrl() }}" title="{{ $post->attachment->file_name }}" class="w-25" />
                                            @else
                                                {{ $post->attachment->file_name }}
                                            @endif
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px;" class="row d-none d-sm-block">
                <div class="col-lg-12">
                    <a class="btn btn-primary" href="{{ route('frontend.posts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
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
            <a class="btn btn-primary btn-block" href="{{ route('frontend.posts.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
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