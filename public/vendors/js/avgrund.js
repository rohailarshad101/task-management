(function($) {
  'use strict';
  $(function() {
    $('#show').avgrund({
      height: 500,
      holderClass: 'custom',
      showClose: true,
      showCloseText: 'x',
      onBlurContainer: '.container-scroller',
      template: '<a class="dropdown-item">' +
        '<p class="mb-0 font-weight-normal float-left">You have <?= $notification_count ?> new notifications</p>' +
        '<span class="btn badge badge-pill badge-warning float-right" id="markAllASRead">Mark all as read</span>' +
        '</a>' +
        '<div class="dropdown-divider"></div>' +
        '</div>'
    });
  })
})(jQuery);