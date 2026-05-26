import { api, normalizeProductos } from '@/services/api'

export const obtenerProductos = async () => {
  const response = await api.get('/productos')
  return normalizeProductos(response.data)
}

export const obtenerProducto = async (id) => {
  const response = await api.get(`/productos/${id}`)
  return response.data
}

export const crearProducto = async (payload) => {
  const response = await api.post('/productos', payload)
  return response.data
}

