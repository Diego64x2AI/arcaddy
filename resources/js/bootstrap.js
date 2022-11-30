import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios'
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.headers.common['X-CSRF-TOKEN'] =  document.querySelector('meta[name="csrf-token"]').getAttribute('content')

// jQuery
import $ from 'jquery'
window.$ = window.jQuery = $

import 'datatables.net'
import 'datatables.net-responsive'
// import 'datatables.net-dt/css/jquery.dataTables'

// Sortable
import Sortable from 'sortablejs'
window.Sortable = Sortable

// SweetAlert2
import Swal from 'sweetalert2'
window.Swal = Swal

// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle'
// import styles bundle
import 'swiper/css/bundle'

window.Swiper = Swiper

import autoComplete from '@tarekraafat/autocomplete.js'
window.autoComplete = autoComplete;

import Isotope from 'isotope-layout'
window.Isotope = Isotope

import { createPopper } from '@popperjs/core'

import flyter, {
  withPopupRenderer,
  // withInlineRenderer,
  withTextType,
  withSelectType,
  // withCheckboxType,
  // withRadioType,
} from 'flyter'
withPopupRenderer()
withTextType()
withSelectType()
// withInlineRenderer()

window.Flyter = flyter

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
