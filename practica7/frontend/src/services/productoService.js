import { api, getApiError, unwrapCollection, unwrapResource } from '@/services/api'

export const obtenerProductos = async (params = {}) => {
  const {
    page = 1,
    perPage = 15,
    q = '',
    busqueda = '',
    categoria = '',
    min = '',
    max = '',
    orden = '',
    dir = '',
    pagina = '',
    por_pagina = '',
  } = params

  const { data } = await api.get('/productos', {
    params: {
      page,
      per_page: perPage,
      q: q || undefined,
      busqueda: busqueda || undefined,
      categoria: categoria || undefined,
      min: min || undefined,
      max: max || undefined,
      orden: orden || undefined,
      dir: dir || undefined,
      pagina: pagina || undefined,
      por_pagina: por_pagina || undefined,
    },
  })

  return unwrapCollection(data)
}

export const obtenerProductosPorCategoria = async (categoriaId) => {
  const { data } = await api.get(`/categorias/${categoriaId}/productos`)
  return unwrapCollection(data)
}

export const obtenerCategorias = async () => {
  const { data } = await api.get('/categorias')
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
