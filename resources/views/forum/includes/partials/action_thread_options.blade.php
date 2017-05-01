  <select title="{{ trans('mod.actions') }}" class="form-control" name="action" id="action">

    <option value="" disabled selected>{{ trans('mod.select_action') }}</option>

    @can('junkThread', @$thread)
        <option value="junk">{{ trans_choice('mod.thread.junk', !isset($threads)) }}</option>
    @endcan

    @can('restoreJunkedThread', @$thread)
    <option value="restore">{{ trans_choice('mod.thread.restore', !isset($threads)) }}</option>
        @endcan

    @can('deleteThread', @$thread)
        <option value="delete">{{ trans_choice('mod.thread.perm_delete', !isset($threads)) }}</option>
    @endcan

    @can('lock', @$thread)
        <option value="lock">{{ trans_choice('mod.thread.lock', !isset($threads)) }} </option>
        <option value="unlock">{{ trans_choice('mod.thread.unlock', !isset($threads)) }} </option>
    @endcan

    @can('pin', @$thread)
        <option value="pin">{{ trans_choice('mod.thread.pin', !isset($threads)) }} </option>
        <option value="unpin">{{ trans_choice('mod.thread.unpin', !isset($threads)) }} </option>
    @endcan

</select>