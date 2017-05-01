<a href="{{ $thread->lastPost->postURL() }}"> {{ trans('forum.post.last_post') }}:</a>
<a href="{{ $thread->lastPost->user->profileURL() }}"> {{ $thread->lastPost->user->info }}</a>
<span class="visible-xs-inline-block">–</span>
<br class="hidden-xs">
{{ $thread->lastPost->created_at }}