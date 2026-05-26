import { api } from '@/plugins/axios'

export const getProductos = async () => {
  const { data } = await api.get('/productos')
  return data
}

export const createProducto = async (payload) => {
  const { data } = await api.post('/productos', payload)
  return data
}

export const updateProducto = async (id, payload) => {
  const { data } = await api.put(`/productos/${id}`, payload)
  return data
}

export const deleteProducto = async (id) => {
  await api.delete(`/productos/${id}`)
}
