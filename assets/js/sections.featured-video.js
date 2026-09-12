/**
 * S54 COFFEE — Featured Video Interactive Player Controller
 * Handles auto-sync with HTML5 video events (play, pause, ended),
 * hides button & overlay smoothly during playback, shows play button when paused.
 */
(function() {
    "use strict";

    function setupFeaturedVideoPlayers() {
        var containers = document.querySelectorAll('.c-featured-video__media-container');
        if (!containers || !containers.length) return;

        containers.forEach(function(container) {
            if (container.dataset.s54VideoInitialized === "true") return;
            container.dataset.s54VideoInitialized = "true";

            var videos = container.querySelectorAll('video');
            var playBtn = container.querySelector('[data-play], .c-featured-video__button-play');
            var inner = container.querySelector('.c-featured-video__inner');

            var PLAY_ICON = '<svg class="o-btn__play" viewBox="0 0 24 24" width="28" height="28" fill="none" style="margin-left:3px!important;" xmlns="http://www.w3.org/2000/svg"><path d="M8 5.14v13.72a1 1 0 001.55.83l11-6.86a1 1 0 000-1.66l-11-6.86A1 1 0 008 5.14z" fill="currentColor"/></svg>';
            var PAUSE_ICON = '<svg class="o-btn__pause" viewBox="0 0 24 24" width="28" height="28" fill="none" style="margin-left:0!important;" xmlns="http://www.w3.org/2000/svg"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z" fill="currentColor"/></svg>';

            function getActiveVideo() {
                for (var i = 0; i < videos.length; i++) {
                    var v = videos[i];
                    if (window.getComputedStyle(v).display !== 'none' && v.offsetWidth > 0) {
                        return v;
                    }
                }
                var isDesktop = window.innerWidth >= 1100;
                var preferred = isDesktop ? container.querySelector('.c-featured-video__media.has-mobile') : container.querySelector('.c-featured-video__media.is-mobile');
                return preferred || videos[0];
            }

            function updateUIState(isPlaying) {
                if (isPlaying) {
                    container.classList.add('is-playing');
                    if (inner) inner.classList.add('is-hidden');
                    if (playBtn) {
                        playBtn.classList.add('is-hidden');
                        playBtn.setAttribute('data-state', 'playing');
                        playBtn.setAttribute('aria-label', 'Tạm dừng video');
                        playBtn.innerHTML = PAUSE_ICON;
                    }
                } else {
                    container.classList.remove('is-playing');
                    if (inner) inner.classList.remove('is-hidden');
                    if (playBtn) {
                        playBtn.classList.remove('is-hidden');
                        playBtn.setAttribute('data-state', 'paused');
                        playBtn.setAttribute('aria-label', 'Phát video');
                        playBtn.innerHTML = PLAY_ICON;
                    }
                }
            }

            // Sync with all native video events
            videos.forEach(function(v) {
                v.addEventListener('play', function() { updateUIState(true); });
                v.addEventListener('playing', function() { updateUIState(true); });
                v.addEventListener('pause', function() { updateUIState(false); });
                v.addEventListener('ended', function() { updateUIState(false); });
            });

            function togglePlayback(e) {
                if (e) {
                    if (e.target.closest('a, button:not([data-play]):not(.c-featured-video__button-play), input')) return;
                    e.preventDefault();
                    e.stopPropagation();
                }
                var active = getActiveVideo();
                if (!active) return;

                if (active.paused) {
                    videos.forEach(function(other) {
                        if (other !== active) {
                            try { other.pause(); } catch(err) {}
                        }
                    });
                    var playPromise = active.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(function(err) {
                            console.warn("Autoplay/play prevented:", err);
                        });
                    }
                } else {
                    active.pause();
                }
            }

            if (playBtn) {
                playBtn.addEventListener('click', togglePlayback);
            }

            container.addEventListener('click', function(e) {
                if (e.target.closest('a, button:not([data-play]):not(.c-featured-video__button-play), input')) return;
                togglePlayback(e);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupFeaturedVideoPlayers);
    } else {
        setupFeaturedVideoPlayers();
    }
})();
