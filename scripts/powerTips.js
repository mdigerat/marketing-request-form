$(document).ready(function(){
  /* Add tooltips to navigation */
  $('nav a').powerTip({
    popupId: 'navTip'
  });

  /* Add text tooltips to photos */
  $('.gallery img').powerTip({
    placement: 'sw-alt',
    followMouse: false
  });

  /* Add new content to text links */
  $('.info-box')
    .on( 'click', function(e) {
      e.preventDefault();
    })
    .powerTip({
      placement: 'e',
      mouseOnToPopup: true,
      smartPlacement: true,
      popupId: 'infoTip'
    });
});