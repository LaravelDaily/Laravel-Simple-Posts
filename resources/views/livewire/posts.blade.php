<div class="card-body">
    <p class="mb-2">
        Categories: <br/>
        @foreach ($categories as $id => $category)
            <div class="badge{{ in_array($id, $selectedCategories) ? ' badge-warning text-white' : '' }}" wire:click="filterCategories({{ $id }})">
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
                        <span class="h4 mr-1 text-white bg-warning rounded p-1">ALL</span>
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
