<div class="modal fade" id="ajax-modal">
    <div class="modal-dialog">
        @include('includes.loading_icon', ['name' => 'modal-loading-icon'])
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('site.close') }}</button>
            </div>
        </div>
    </div>
</div>