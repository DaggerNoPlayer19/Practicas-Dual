import { api, getApiError, unwrapCollection, unwrapResource } from '@/services/api'

export const obtenerProductos = async ({ page = 1, perPage = 10, q = '' } = {}) => {
  const { data } = await api.get('/productos', {
    params: {
      page,
      per_page: perPage,
      q: q || undefined,
    },
  })

  return unwrapCollection(data)
}

export const obtenerProducto = async (id) => {
  const { data } = await api.get(`/productos/${id}`)
  return unwrapResource(data)
}

export const crearProducto = async (formData) => {
  const { data } = await api.post('/productos', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })

  return unwrapResource(data)
}

export const actualizarProducto = async (id, formData) => {
  formData.append('_method', 'PUT')

  const { data } = await api.post(`/productos/${id}`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })

  return unwrapResource(data)
}

export const eliminarProducto = async (id) => {
  await api.delete(`/productos/${id}`)
}

export { getApiError }
