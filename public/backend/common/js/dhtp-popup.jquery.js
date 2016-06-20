$(function(){

  var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

  $('input[data-modal-id]').click(function(e) {
    e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
    var modalBox = $(this).attr('data-modal-id');
    $('#'+modalBox).fadeIn($(this).data());
  });  
  
  
  $(".js-modal-close, .modal-overlay").click(function(e) {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        e.preventDefault();
        $(".modal-overlay").remove();
    });
 
  });
 
  $(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
  });
 
  $(window).resize();
 
});