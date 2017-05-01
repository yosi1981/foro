<form method="POST" class="inline" action="{{ route('forum.actions.post') }}">
    {{ csrf_field() }}
    <input type="hidden" name="model-input" value="{{ $post->id }}">
    <input type="hidden" name="action" value="{{ $post->trashed() ? 'restore' : 'junk' }}">
    <button title="{{ $post->trashed() ? trans_choice('mod.post.restore', 1) : trans_choice('mod.post.junk', 1) }}" type="submit" class="btn btn-default btn-sm" name="ays-confirm">
        <i class="fa fa-{{ $post->trashed() ? 'refresh' : 'trash' }}"></i>
    </button>
</form>