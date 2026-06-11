import { api, unwrapResource } from '@/services/api'

export const createPedido = async (items) => {
  const { data } = await api.post('/pedidos', { items })
  return unwrapResource(data)
}

export const getPedido = async (id) => {
  const { data } = await api.get(`/pedidos/${id}`)
  return unwrapResource(data)
}
