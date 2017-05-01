<form method="POST" action="{{ route('forum.actions.post') }}">

    {{ csrf_field() }}
    <input type="hidden" class="mod-selected-results" name="model-input" value="">

    {{-- Select field --}}
    <div class="col-xs-8 padding-0 margin-0">
        <select title="{{ trans('site.actions') }}" class="form-control" name="action" id="action">

            {{-- Default select option--}}
            <option value="" disabled selected>{{ trans('mod.select_action') }}</option>

            @can('forum-moderate-junk-post')
                <option value="junk">{{ trans_choice('mod.post.junk', 2) }}</option>
            @endcan

            @can('forum-moderate-junked-post')
                <option value="restore">{{ trans_choice('mod.post.restore', 2) }}</option>
            @endcan

            @can('forum-moderate-delete-post')
                <option value="delete">{{ trans_choice('mod.post.perm_delete', 2) }}</option>
            @endcan

            @can('forum-moderate-thread')
                <option value="hideSignature">{{ trans('mod.signature.hide') }}</option>
            @endcan

            @can('forum-moderate-thread')
                <option value="showSignature">{{ trans('mod.signature.show') }}</option>
            @endcan

        </select>
    </div>

    {{-- Proceed Button --}}
    @include('forum.includes.partials.proceed_button')

</form>