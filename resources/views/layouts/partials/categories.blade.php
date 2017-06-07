<div class="col-md-3">
    <h4>Category</h4>
    <ul class="list-group">
        <a href="{{route('thread.index')}}" class="list-group-item">
            <span class="badge"></span>
            All Thread
        </a>
        @foreach($tags as $tag)
        
        <a href="{{ route('tag', ['slug' => $tag->slug ]) }}" style="text-decoration: none;" class="list-group-item">
            <span class="badge">{{ $tag->threads()->count() }}</span>
        {{ $tag->title }}

        </a>
        
        @endforeach
    </ul>
</div>