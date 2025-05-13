import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher  // cho Echo nhận được Pusher client
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('orderId')
  if (!el) {
    console.warn('No #orderId element, skipping Echo subscription')
    return
  }
  const orderId = el.value

  window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    disableStats: true,
    auth: {
      headers: {
        'X-CSRF-TOKEN': document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute('content'),
      },
    },
  })

  console.log('▶️ Subscribing to private-order.' + orderId)
  window.Echo.private(`order.${orderId}`)
    .listen('OrderCreated', e => {
      console.log('🟢 Received OrderCreated:', e)
    })
})




