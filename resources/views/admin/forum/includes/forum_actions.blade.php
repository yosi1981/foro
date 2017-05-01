<div class="box box-flat">
    <div class="box-header with-border">
        <h3 class="box-title">Forum Actions</h3>
    </div>
    <div class="box-body">
        <div class="row">

            <div class="col-sm-3 col-xs-6">
                <a href="{{ route('admin.forum.manage.move', $forum->id) }}" class="btn btn-default">
                    <i class="fa fa-arrows"></i> {{ trans_choice('mod.thread.move', 2) }}</a>
                <span class="help-block">{{ trans('forum.thread.move_desc') }}</span>
            </div>

            <div class="col-sm-3 col-xs-6">
                <form method="post" action="{{ route('admin.forum.manage.junk_threads', $forum->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="submit" name="ays-confirm" class="btn btn-warning"><i class="fa fa-times"></i>
                        {{ trans_choice('mod.thread.junk', 2) }}
                    </button>
                    <span class="help-block">{{ trans('forum.thread.junk_desc') }}</span>
                </form>
            </div>

            <div class="col-sm-3 col-xs-6">
                <form method="post" action="{{ route('admin.forum.manage.restore_threads', $forum->id) }}">
                    {{ csrf_field() }}
                    <button type="submit" name="ays-confirm" class="btn btn-primary"><i class="fa fa-refresh"></i>
                        {{ trans_choice('mod.thread.restore', 2) }}
                    </button>
                    <span class="help-block">{{ trans('forum.thread.restore_desc') }}</span>
                </form>
            </div>

            <div class="col-sm-3 col-xs-6">
                <form method="post" action="{{ route('admin.forum.manage.delete_threads', $forum->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="submit" name="ays-confirm" class="btn btn-danger"><i class="fa fa-trash"></i>
                        {{ trans_choice('mod.thread.delete', 2) }}
                    </button>
                    <span class="help-block">{{ trans('forum.thread.delete_desc') }}</span>
                </form>
            </div>

        </div>
        {!! trans('forum.action_may_take_time') !!}
        <hr>
        <form action="{{ route('admin.forum.destroy', $forum->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button name="ays-confirm" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('forum.delete') }}</button>
        </form>
        <span class="help-block">
            {{ trans('forum.delete_desc') }}
        </span>
    </div>
</div>