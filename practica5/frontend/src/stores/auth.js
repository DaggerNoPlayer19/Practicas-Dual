import { defineStore } from 'pinia'
import { api, getApiError } from '@/services/api'

const TOKEN_KEY = 'practica5_token'
const USER_KEY = 'practica5_user'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem(TOKEN_KEY) || '',
    user: JSON.parse(localStorage.getItem(USER_KEY) || 'null'),
    tokenAbilities: JSON.parse(localStorage.getItem('practica5_abilities') || '[]'),
    loading: false,
    error: '',
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
    isAdmin: (state) => Boolean(state.user?.is_admin),
  },

  actions: {
    setSession(token, user, abilities = []) {
      this.token = token
      this.user = user
      this.tokenAbilities = abilities
      localStorage.setItem(TOKEN_KEY, token)
      localStorage.setItem(USER_KEY, JSON.stringify(user))
      localStorage.setItem('practica5_abilities', JSON.stringify(abilities))
    },

    clearSession() {
      this.token = ''
      this.user = null
      this.tokenAbilities = []
      this.error = ''
      localStorage.removeItem(TOKEN_KEY)
      localStorage.removeItem(USER_KEY)
      localStorage.removeItem('practica5_abilities')
    },

    async fetchUser() {
      if (!this.token) {
        return
      }

      try {
        const { data } = await api.get('/me')
        this.user = data.user
        this.tokenAbilities = data.abilities || []
        localStorage.setItem(USER_KEY, JSON.stringify(data.user))
        localStorage.setItem('practica5_abilities', JSON.stringify(data.abilities || []))
      } catch {
        this.clearSession()
      }
    },

    async login(payload) {
      this.loading = true
      this.error = ''

      try {
        const { data } = await api.post('/login', payload)
        this.setSession(data.token, data.user, data.abilities || [])
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
        this.setSession(data.token, data.user, data.abilities || [])
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
