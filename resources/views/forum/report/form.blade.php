<div id="report-post-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        @include('includes.loading_icon', ['name' => 'modal-loading-icon'])
        <div class="modal-content">
            <form id="report-post" method="post" action="{{ route('forum.report', 60) }}">
                <div id="report-body"></div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        reportPost('{{ route('forum.report.form') }}');
    </script>
@endpush