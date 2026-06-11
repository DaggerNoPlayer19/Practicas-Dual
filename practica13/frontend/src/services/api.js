import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000'
const API_VERSION = import.meta.env.VITE_API_VERSION || 'v1'
const TOKEN_KEY = 'practica13_token'

export const api = axios.create({
  baseURL: `${API_URL}/api/${API_VERSION}`,
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem(TOKEN_KEY)

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

export const getApiError = (error, fallback = 'Ocurrio un error inesperado.') => {
  if (error.response?.data?.message) {
    return error.response.data.message
  }

  const errors = error.response?.data?.errors
  if (errors) {
    const firstKey = Object.keys(errors)[0]
    if (firstKey && errors[firstKey]?.[0]) {
      return errors[firstKey][0]
    }
  }

  return fallback
}

export const unwrapCollection = (payload) => {
  if (Array.isArray(payload)) {
    return { data: payload, meta: null }
  }

  return {
    data: payload?.data ?? [],
    meta: payload?.meta ?? null,
  }
}

export const unwrapResource = (payload) => payload?.data ?? payload
