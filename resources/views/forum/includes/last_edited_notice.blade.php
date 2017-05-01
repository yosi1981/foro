@if ($signed_in && $post->lastEdit && $user->can('forum-see-last-edited-info'))
    <div class="notice">
        {{-- If the user can see who last edited the past --}}
        @can('forum-see-last-edited-user')
            {{ trans('forum.post.last_edited.by') }}
                <a href="{{ $post->lastEdit->user->profileURL() }}" class="username-coloured">{{ $post->lastEdit->user->info }}</a>
            –
            @else
                {{ trans('forum.post.last_edited.label') }}
        @endcan
            {{ $post->updated_at }}
    </div>
@endif