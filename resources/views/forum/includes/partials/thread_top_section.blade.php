{{-- Thread Title and Thread Icons --}}
<section class="clouds forum-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <h3 class="font-weight-300">
                     Thread Icon only if thread has been pinned/locked
                    @if ($thread->pinned || $thread->locked)
                        <img height="30" src="{{ $thread->icon() }}" alt="">
                    @endif

                     Thread title
                    {{ $thread->title }}

                </h3>

                {{--If the thread has been locked... --}}
                @if ($thread->locked)
                    <span class="help-block">{{ trans('forum.thread.locked') }} </span>
                @endif

            </div>
        </div>
    </div>
</section>