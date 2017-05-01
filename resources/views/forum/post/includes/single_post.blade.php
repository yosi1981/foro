<div id="post-{{ $post->id }}" class="panel {{ $post->trashed() ? ' post-deleted' : '' }}">
    <div class="panel-body">
        <div class="forum-post-profile">
            <dt class="has-avatar">
            <div class="avatar-container">
                <a href="{{ $post->user->profileURL() }}" class="avatar">
                    <img width="50" height="50" class="img-circle img-responsive avatar" src="{{ $post->user->avatar }}" alt="User avatar"/>
                </a>
            </div>

            {{-- Username Display --}}
            <a href="{{ $post->user->profileURL() }}" class="username-coloured">{{ $post->user->info }}</a>

            {{-- Stars --}}
            <div class="profile-stars">{!! $post->user->forumTitle()['stars'] !!}</div>

            <div class="text-normal">
                {{-- User Rank--}}
                <div class="profile-rank">
                    {{ $post->user->forumTitle()['title'] }}
                </div>

                {{-- Total posts --}}
                <div class="profile-posts">
                    <strong>{{ trans_choice('forum.post.label', $post->user->totalPosts()) }}:</strong>
                    <a href="">{{ $post->user->totalPosts() }}</a>
                </div>
                {{-- Joined date--}}
                <strong>{{ trans('user.registered') }}:</strong> {{ $post->user->created_at }}


            </div>

            {{-- "Select Post #" checkbox for mass actions for moderation --}}
            @if ($signed_in && $user->canModeratePost())

                <hr class="visible-lg visible-md padding-0 margin-top-10 margin-bottom-10 margin-0">

                <label class="text-normal" for="post[{{ $post->id }}]">
                    <input id="post[{{ $post->id }}]" class="mod-checkbox-select-result" name="post[{{ $post->id }}]" value="{{ $post->id }}" type="checkbox">
                    {{ trans('mod.post.select', ['number' => $post->orderNumber($posts, $key)]) }}
                </label>

            @endif
        </div>

        <div class="forum-body">
            <div class="pull-right">
                <div class="btn-group">
                    @can('editPost', $post)
                        @include('forum.post.includes.buttons.edit_post_button')
                    @endcan
                    @can('forum-report-post')
                        @include('forum.post.includes.buttons.report_post_button')
                    @endcan
                    @can('forum-reply')
                        @include('forum.post.includes.buttons.quote_post_button')
                    @endcan
                </div>
                @can('junkPost', $post)
                @include('forum.post.includes.buttons.delete_post_button')
                @endcan
            </div>
            <span class="help-block forum-time-posted">

                <a class="scroll text-muted" href="{{ $post->postURL() }}">
                    #{{ $post->orderNumber($posts, $key) }} –
                    {{ $post->created_at }}
                </a>

                {{ $post->trashed() ? ' – '. trans('mod.junked') . " {$post->deleted_at}" : '' }}

            </span>

            {{-- Message --}}
            <div class="forum-content padding-bottom-30">
                {!!  BBCode::parse($post->message) !!}
            </div>

            {{-- Last edited notice --}}
            @include('forum.includes.last_edited_notice')
        </div>

    </div>
    @if ($post->signature && $post->user->can('forum-use-signature') && $post->user->hasSignature())
        <div {{ \App\Core\Core::signatureAttributes() }} class="forum-signature">
            {!!   BBCode::parse($post->user->signature)  !!}
        </div>
    @endif
</div>