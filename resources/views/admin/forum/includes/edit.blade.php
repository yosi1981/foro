<div class="box box-flat">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('forum.edit') }}: {{ $forum->name }}</h3>
    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal use-ajax" action="{{ route('admin.forum.update', $forum->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}

            @include('admin.forum.form')

            <div class="col-sm-offset-2 col-md-offset-1">
                @include('includes.buttons.save')
            </div>
        </form>
    </div>
</div>