<div class="btn-group">
    <button id="resolved" type="button" class="btn btn-danger btn-sm mod-action-button">
        {{ trans('site.mark_as_read') }}
    </button>
    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
        <br>
        <span class="sr-only">{{ trans('site.toggle_dropdown') }}</span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="mod-action-button" id="deleteReport" href="#">
                {{ trans_choice('mod.report.delete', 2) }}
            </a></li>
        <li>
            <a class="mod-action-button" id="deletePost" href="#">
                {{ trans_choice('mod.post.junk', 2) }}
            </a>
        </li>
    </ul>
</div>