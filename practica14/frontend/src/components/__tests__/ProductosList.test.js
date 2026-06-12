import { flushPromises, mount } from '@vue/test-utils'
import { vi } from 'vitest'
import ProductosList from '../ProductosList.vue'

vi.mock('@/services/productoService', () => ({
  obtenerProductos: vi.fn(),
  eliminarProducto: vi.fn(),
  getApiError: vi.fn((error, fallback) => error?.message || fallback),
}))

import { eliminarProducto, obtenerProductos } from '@/services/productoService'

describe('ProductosList', () => {
  beforeEach(() => {
    vi.clearAllMocks()
    vi.spyOn(window, 'confirm').mockReturnValue(true)
  })

  afterEach(() => {
    window.confirm.mockRestore()
  })

  it('carga y muestra productos desde la API', async () => {
    obtenerProductos.mockResolvedValue({
      data: [
        { id: 1, nombre: 'Mouse', precio: 25, stock: 3, categoria: { nombre: 'Electronica' } },
      ],
    })

    const wrapper = mount(ProductosList)
    await flushPromises()

    expect(obtenerProductos).toHaveBeenCalledWith({ page: 1, perPage: 20 })
    expect(wrapper.text()).toContain('Mouse')
    expect(wrapper.text()).toContain('Electronica')
  })

  it('elimina un producto y recarga la lista', async () => {
    obtenerProductos.mockResolvedValue({
      data: [
        { id: 1, nombre: 'Mouse', precio: 25, stock: 3, categoria: { nombre: 'Electronica' } },
      ],
    })
    eliminarProducto.mockResolvedValue({})

    const wrapper = mount(ProductosList)
    await flushPromises()

    await wrapper.get('button.btn-danger').trigger('click')
    await flushPromises()

    expect(eliminarProducto).toHaveBeenCalledWith(1)
  })
})
