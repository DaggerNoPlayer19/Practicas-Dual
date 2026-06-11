import { defineStore } from 'pinia'
import { api, getApiError } from '@/services/api'

const TOKEN_KEY = 'practica12_token'
const USER_KEY = 'practica12_user'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem(TOKEN_KEY) || '',
    user: JSON.parse(localStorage.getItem(USER_KEY) || 'null'),
    loading: false,
    error: '',
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
    isAdmin: (state) => Boolean(state.user?.is_admin),
  },

  actions: {
    setSession(token, user) {
      this.token = token
      this.user = user
      localStorage.setItem(TOKEN_KEY, token)
      localStorage.setItem(USER_KEY, JSON.stringify(user))
    },

    clearSession() {
      this.token = ''
      this.user = null
      this.error = ''
      localStorage.removeItem(TOKEN_KEY)
      localStorage.removeItem(USER_KEY)
    },

    async fetchUser() {
      if (!this.token) {
        return
      }

      try {
        const { data } = await api.get('/me')
        this.user = data
        localStorage.setItem(USER_KEY, JSON.stringify(data))
      } catch {
        this.clearSession()
      }
    },

    async login(payload) {
      this.loading = true
      this.error = ''

      try {
        const { data } = await api.post('/login', payload)
        this.setSession(data.token, data.user)
        return true
      } catch (error) {
        this.error = getApiError(error, 'No se pudo iniciar sesion.')
        return false
      } finally {
        this.loading = false
      }
    },

    async register(payload) {
      this.loading = true
      this.error = ''

      try {
        const { data } = await api.post('/register', payload)
        this.setSession(data.token, data.user)
        return true
      } catch (error) {
        this.error = getApiError(error, 'No se pudo registrar usuario.')
        return false
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        await api.post('/logout')
      } catch {
        // Si el token ya expiro, igual limpiamos sesion local.
      } finally {
        this.clearSession()
      }
    },
  },
})
