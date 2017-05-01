<div class="box box-flat">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <div class="description-block border-right">
                    <h5 class="description-header">{{ $forum->total_threads }}</h5>
                    <span class="description-text">{{ trans('forum.thread.total') }}</span>
                </div>
            </div>
            <div class="col-sm-6 col-xs-6">
                <div class="description-block">
                    <h5 class="description-header">{{ $forum->total_posts }}</h5>
                    <span class="description-text">{{ trans('forum.post.total') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>