var navbox = $('.account-settings-tabs');
navbox.on('click', 'a', function (e) {
    var $this = $(this);
    e.preventDefault();
    window.location.hash = $this.attr('href');
    $this.tab('show');
});
if(window.location.hash){
    navbox.find('a[href="'+window.location.hash+'"]').tab('show');
}