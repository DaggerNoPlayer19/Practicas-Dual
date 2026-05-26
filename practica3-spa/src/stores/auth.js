import { defineStore } from 'pinia'

const TOKEN_KEY = 'practica3_token'
const USER_KEY = 'practica3_user'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem(TOKEN_KEY) || '',
    user: null,
    loading: false,
    error: '',
  }),
  getters: {
    isAuthenticated: (state) => Boolean(state.token),
  },
  actions: {
    async fetchUser() {
      if (!this.token) {
        return
      }

      const raw = localStorage.getItem(USER_KEY)
      this.user = raw ? JSON.parse(raw) : null

      if (!this.user) {
        this.token = ''
        localStorage.removeItem(TOKEN_KEY)
      }
    },
    async login({ email, password }) {
      this.loading = true
      this.error = ''

      try {
        if (!email || !password) {
          throw new Error('Debes capturar correo y contraseña.')
        }

        const fakeToken = `token_${Date.now()}`
        const fakeUser = {
          name: email.split('@')[0] || 'usuario',
          email,
        }

        this.token = fakeToken
        this.user = fakeUser
        localStorage.setItem(TOKEN_KEY, fakeToken)
        localStorage.setItem(USER_KEY, JSON.stringify(fakeUser))
        return true
      } catch (error) {
        this.error = error.message || 'No fue posible iniciar sesión.'
        return false
      } finally {
        this.loading = false
      }
    },
    logout() {
      this.token = ''
      this.user = null
      this.error = ''
      localStorage.removeItem(TOKEN_KEY)
      localStorage.removeItem(USER_KEY)
    },
  },
})

