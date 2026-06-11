import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const getAuthToken = () => localStorage.getItem('practica13_token') || ''

export const createEcho = () =>
  new Echo({
    broadcaster: 'reverb',
    namespace: 'App.Events',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'practica13-key',
    wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
    wsPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: `${import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000'}/broadcasting/auth`,
    auth: {
      headers: {
        Authorization: `Bearer ${getAuthToken()}`,
      },
    },
  })

