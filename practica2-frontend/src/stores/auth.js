import { defineStore } from 'pinia'
import { api } from '@/plugins/axios'

const getErrorMessage = (error, fallback) => {
  if (error.response?.data?.message) {
    return error.response.data.message
  }

  const errors = error.response?.data?.errors
  if (errors) {
    const firstField = Object.keys(errors)[0]
    if (firstField && errors[firstField]?.[0]) {
      return errors[firstField][0]
    }
  }

  return fallback
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || '',
    loading: false,
    error: '',
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
  },

  actions: {
    setSession(token, user) {
      this.token = token
      this.user = user
      localStorage.setItem('token', token)
    },

    clearSession() {
      this.token = ''
      this.user = null
      this.error = ''
      localStorage.removeItem('token')
    },

    async register(payload) {
      this.loading = true
      this.error = ''

      try {
        const response = await api.post('/register', payload)
        this.setSession(response.data.token, response.data.user)
        return true
      } catch (error) {
        this.error = getErrorMessage(error, 'No fue posible crear la cuenta.')
        return false
      } finally {
        this.loading = false
      }
    },

    async login(payload) {
      this.loading = true
      this.error = ''

      try {
        const response = await api.post('/login', payload)
        this.setSession(response.data.token, response.data.user)
        return true
      } catch (error) {
        this.error = getErrorMessage(error, 'No fue posible iniciar sesion.')
        return false
      } finally {
        this.loading = false
      }
    },

    async fetchMe() {
      if (!this.token) {
        return
      }

      try {
        const response = await api.get('/me')
        this.user = response.data
      } catch {
        this.clearSession()
      }
    },

    async logout() {
      this.loading = true
      this.error = ''

      try {
        await api.post('/logout')
      } catch {
        // El token puede haber expirado; limpiamos estado local de cualquier forma.
      } finally {
        this.clearSession()
        this.loading = false
      }
    },
  },
})
