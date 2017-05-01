<form class="inline" method="post" action="{{ route('mod.banned.destroy', $ban->user->info) }}">
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <button name="ays-confirm"  class="padding-0 btn btn-link">{{ trans('site.delete') }}</button>
</form>