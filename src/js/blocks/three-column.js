/* eslint-env jquery */
const $ = jQuery;
if ($('.three-column').length) {
  $(document).ready(threeColumnInit);
  $(window).on('resize', threeColumnMatchHeight);
}

function threeColumnInit() {
  threeColumnMatchHeight();
}

function threeColumnMatchHeight() {
  $('.three-column .col-md-4 .title-holder').matchHeight();
  $('.three-column .col-md-4 .content-holder').matchHeight();
}
