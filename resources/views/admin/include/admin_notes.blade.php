<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.dashboard.note.title') }}</h3>
    </div>
    <div class="box-body">
        <form class="use-ajax" method="POST" action="{{ route('admin.update.note') }}">
            {{ method_field('patch') }}
            {{ csrf_field() }}
            @include('mod.includes.dashboard_note', ['note_title' => trans('admin.dashboard.note.title'), 'note' => $admin_note, 'note_helper' => trans('admin.dashboard.note.visible_to_all_admin')])
        </form>
    </div>
</div>