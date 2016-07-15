$(function() {
    // Javascript to enable link to tab
    var hash = document.location.hash;
    if (hash) {
      console.log(hash);
      $('.nav-tabs a[href='+hash+']').tab('show');
    }

    // Change hash for page-reload
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
       window.location.hash = e.target.hash;
     });
});
