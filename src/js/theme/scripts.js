/* eslint-env jquery */
const $ = jQuery;
// eslint-disable-next-line no-unused-vars
let wpadminbar = 0;
$(document).ready(init);
function init() {
  if ($('#wpadminbar').length) {
    adminSize();
  }
}

$(window).on('resize', resize);

function resize() {
  if ($('#wpadminbar').length) {
    adminSize();
  }
}

function adminSize() {
  $('#wpadminbar').prependTo('#wrapper-navbar');
  // eslint-disable-next-line no-unused-expressions
  window.matchMedia('(max-width: 782.98px)').matches ? (wpadminbar = 46) : (wpadminbar = 32);
}
