<div class="panel panel-default">
    <div class="panel-body padding-bottom-10 padding-top-10">
        <div class="row">
            <div class="col-xs-11 col-sm-9">
               {{ trans_choice('forum.thread.label', 2) }}
            </div>
            <div class="hidden-xs col-sm-1 text-center text-nowrap">
                    <i class="fa fa-reply visible-sm"></i>
                    <span class="hidden-sm"> {{ trans_choice('forum.thread.reply.label', 2) }}</span>
            </div>
            <div class="hidden-xs col-sm-2 text-right text-nowrap">
                    <i class="fa fa-clock-o visible-sm"></i>
                    <span class="hidden-sm">{{ trans('forum.post.last_post') }}</span>
            </div>
        </div>
    </div>
    <div class="list-group">
        @if(count($threads) > 0)
            @each('forum.thread.list_item', $threads, 'thread')
        @endif
    </div>
</div>