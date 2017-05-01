@push('css')
<link href="{{ asset('/js/bbcode/jquery.sceditor.default.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('/js/bbcode/jquery.sceditor.bbcode.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/js/bbcode/themes/default.min.css') }}">
<script>
    $(function () {
        $("#bb_editor").sceditor({
            plugins: "bbcode",
            width: "98%",
            parserOptions: false,
            toolbar: "bold,italic,underline,strike|left,center,right,justify|font,size,color|horizontalrule|code,quote|bulletlist,orderedlist|link,image,youtube|source",
            emoticonsEnabled: false,
            fonts: "Source Sans Pro, Helvetica, Arial, Impact, Courier New, Times New Roman, Verdana",
            style: "{{ asset('js/bbcode/jquery.sceditor.default.min.css')}}"
        });
    });
</script>

<script type="text/javascript">
    $(window).load(function () {
        var frame = $('iframe').get(0);
        if (frame != null) {
            var frmHead = $(frame).contents().find('head');
            if (frmHead != null) {
                frmHead.append($('style, link[rel=stylesheet]').clone());
            }
        }
    });
</script>

@endpush