/* eslint-env jquery */
const $ = jQuery;
const body = $('body');
if ($('.video-slider').length) {
  $(document).ready(videoSliderInit);
}

function videoSliderInit() {
  videoSliderClass();
  multipleVideos();
}

function videoSliderClass() {
  $('.video-slider button').hover(function () {
    $('.video').removeClass('current col-md-6').addClass('col-md-2');
    $(this).parent().removeClass('col-md-2').addClass('current col-md-6');
  });
}

function youtubeVideoEvents(targetModal) {
  let player;

  const playerTarget = targetModal.slice(1);

  $(targetModal).on('shown.bs.modal', () => {
    body.removeClass(`stopped-video-${playerTarget}`);

    function onYouTubeIframeAPIReady() {
      const regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
      const match = $(`${targetModal} .youtube`).attr('data-src').match(regExp);

      // eslint-disable-next-line no-undef
      player = new YT.Player(`${playerTarget}-youtube-player`, {
        height: '390',
        width: '640',
        videoId: match[2],
        playerVars: {
          playsinline: 1
        }
      });
    }

    if (!body.hasClass(`playerReady-${playerTarget}`)) {
      onYouTubeIframeAPIReady();
    }
  });
  $(targetModal).on('hide.bs.modal', () => {
    player.pauseVideo();
    setTimeout(() => {
      player.stopVideo();
    }, 100);
    body.addClass(`stopped-video-${playerTarget}`);
  });
}

function vimeoVideoEvents(targetModal) {
  let player;
  const playerTarget = targetModal.slice(1);
  $(targetModal).on('shown.bs.modal', () => {
    // eslint-disable-next-line no-undef
    player = new Vimeo.Player(`${playerTarget}-vimeo-holder`);
    player.play();
  });
  $(targetModal).on('hide.bs.modal', () => {
    // player.pauseVideo();
    player.pause();
    setTimeout(() => {
      player.unload();
    }, 100);
  });
}

function multipleVideos() {
  const video = $('button.video');
  if (video.length > 0) {
    if ($('#youtube-script').length <= 0) {
      const tag = document.createElement('script');
      tag.id = 'youtube-script';
      tag.src = 'https://www.youtube.com/iframe_api';
      const firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    if ($('#vimeo-script').length <= 0) {
      const tag = document.createElement('script');
      tag.id = 'vimeo-script';
      tag.src = 'https://player.vimeo.com/api/player.js';
      const firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    video.each(function () {
      const _t = $(this);
      const dataTarget = _t.attr('data-bs-target');
      const playerYTSource = $(`${dataTarget} .youtube`).attr('data-src');
      const playerVSource = $(`${dataTarget} .vimeo`).attr('data-src');

      if (
        typeof playerYTSource !== 'undefined' &&
        playerYTSource !== false &&
        playerYTSource.includes('youtube')
      ) {
        youtubeVideoEvents(dataTarget);
      }

      if (
        typeof playerVSource !== 'undefined' &&
        playerVSource !== false &&
        playerVSource.includes('vimeo')
      ) {
        vimeoVideoEvents(dataTarget);
      }
    });
  }
}
