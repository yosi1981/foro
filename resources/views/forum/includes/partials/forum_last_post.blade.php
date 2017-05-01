<a href="{{ $subforum->lastThread->threadURL() }}">{{ $subforum->lastThread->title }}</a>
<br>
<a href="{{ $subforum->lastPost->postURL() }}">{{ trans('forum.post.last_post') }}:</a>
<a href="{{ $subforum->lastPostUser->profileURL() }}">
    {{ $subforum->lastPostUser->info }}
</a>
<br>
{{ $subforum->lastPost->created_at }}