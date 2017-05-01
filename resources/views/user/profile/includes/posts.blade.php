@foreach ($posts as $post)
    <div class="post">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="{{ $member->avatar }}" alt="user image">
            <span class="username text-normal font-normal">
                <a class="bold" href="#">{{ $member->info }}</a>
                @if ($post->isFirstPost())
                    {{ trans('user.profile.created_new_thread') }}
                @else
                    {{ trans('user.profile.posted_on') }}
                @endif
                <a class="bold" href="{{ $post->postURL() }}">
                    {{ $post->thread->title }}
                </a>
            </span>
            <span class="description">{{ $post->created_at }}</span>
        </div>
        <p>
            {!!  str_limit(strip_tags(BBCode::parse($post->message)), 150) !!}
        </p>
    </div>
@endforeach