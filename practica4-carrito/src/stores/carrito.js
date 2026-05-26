import { computed, ref, watch } from 'vue'
import { defineStore } from 'pinia'

const STORAGE_KEY = 'practica4_carrito'

export const useCarritoStore = defineStore('carrito', () => {
  const items = ref(JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'))

  const totalItems = computed(() => items.value.reduce((suma, item) => suma + item.cantidad, 0))
  const totalPrecio = computed(() => items.value.reduce((suma, item) => suma + item.precio * item.cantidad, 0))

  const cantidadDeProducto = (id) => items.value.find((item) => item.id === id)?.cantidad || 0

  const agregar = (producto) => {
    const existente = items.value.find((item) => item.id === producto.id)

    if (existente) {
      existente.cantidad += 1
      return
    }

    items.value.push({
      id: producto.id,
      nombre: producto.nombre,
      precio: Number(producto.precio),
      descripcion: producto.descripcion || '',
      cantidad: 1,
    })
  }

  const quitar = (id) => {
    items.value = items.value.filter((item) => item.id !== id)
  }

  const cambiarCantidad = (id, cantidad) => {
    const item = items.value.find((producto) => producto.id === id)
    if (!item) {
      return
    }

    if (cantidad <= 0) {
      quitar(id)
      return
    }

    item.cantidad = cantidad
  }

  const vaciar = () => {
    items.value = []
  }

  watch(
    items,
    (nuevoEstado) => {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(nuevoEstado))
    },
    { deep: true },
  )

  return {
    items,
    totalItems,
    totalPrecio,
    cantidadDeProducto,
    agregar,
    quitar,
    cambiarCantidad,
    vaciar,
  }
})
