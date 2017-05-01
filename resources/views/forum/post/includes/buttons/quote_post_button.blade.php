<a class="btn btn-default btn-sm" href="{{ route('forum.reply', [$post->thread->id, 'quote' => $post->id]) }}" title="{{ trans('forum.post.quote') }}">
    <i class="fa fa-quote-left"></i>
</a>