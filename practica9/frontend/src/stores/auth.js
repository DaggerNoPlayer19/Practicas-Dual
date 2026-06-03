import { defineStore } from 'pinia'
import { api, getApiError } from '@/services/api'

const TOKEN_KEY = 'practica9_token'
const USER_KEY = 'practica9_user'
const DEFAULT_PERMISSIONS = { crear: false, editar: false, eliminar: false }

const loadStoredUser = () => {
  try {
    return JSON.parse(localStorage.getItem(USER_KEY) || 'null')
  } catch {
    return null
  }
}

const normalizePermissions = (source = {}) => ({
  crear: Boolean(source.crear),
  editar: Boolean(source.editar),
  eliminar: Boolean(source.eliminar),
})

const storedUser = loadStoredUser()

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem(TOKEN_KEY) || '',
    user: storedUser,
    permisos: normalizePermissions(storedUser?.permisos || DEFAULT_PERMISSIONS),
    loading: false,
    error: '',
  }),

  getters: {
    isAuthenticated: (state) => Boolean(state.token),
    isStaff: (state) => ['admin', 'editor'].includes(state.user?.rol),
    rol: (state) => state.user?.rol || 'cliente',
    can: (state) => (permiso) => Boolean(state.permisos?.[permiso]),
  },

  actions: {
    setSession(token, user) {
      this.token = token
      this.user = user
      this.permisos = normalizePermissions(user?.permisos || DEFAULT_PERMISSIONS)
      localStorage.setItem(TOKEN_KEY, token)
      localStorage.setItem(USER_KEY, JSON.stringify(user))
    },

    clearSession() {
      this.token = ''
      this.user = null
      this.permisos = { ...DEFAULT_PERMISSIONS }
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
        this.permisos = normalizePermissions(data?.permisos || DEFAULT_PERMISSIONS)
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
