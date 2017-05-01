<div id="are-you-sure-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>{{ trans('site.are_you_sure.title') }}</h4>
                <p>{{ trans('site.are_you_sure.description') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default ays-cancel-btn" data-dismiss="modal">{{ trans('site.no') }}</button>
                <button type="button" class="btn btn-danger ays-yes-btn">{{ trans('site.yes') }}</button>
            </div>
        </div>
    </div>
</div>