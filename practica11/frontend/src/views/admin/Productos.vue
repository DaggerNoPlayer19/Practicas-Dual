<script setup>
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { eliminarProducto, getApiError, obtenerProductos } from '@/services/productoService'

const productos = ref([])
const loading = ref(false)
const error = ref('')
const message = ref('')

const cargar = async () => {
  loading.value = true
  error.value = ''

  try {
    const { data } = await obtenerProductos({ page: 1, perPage: 20 })
    productos.value = data
  } catch (err) {
    error.value = getApiError(err, 'No fue posible cargar inventario.')
  } finally {
    loading.value = false
  }
}

const borrar = async (id) => {
  if (!confirm('Deseas eliminar este producto?')) {
    return
  }

  try {
    await eliminarProducto(id)
    message.value = 'Producto eliminado correctamente.'
    setTimeout(() => {
      message.value = ''
    }, 2500)
    await cargar()
  } catch (err) {
    error.value = getApiError(err, 'No se pudo eliminar el producto.')
  }
}

onMounted(async () => {
  await cargar()
})
</script>

<template>
  <div>
    <div class="row-between">
      <h1>Gestion de productos</h1>
      <RouterLink class="btn" to="/admin/nuevo">Nuevo producto</RouterLink>
    </div>

    <p v-if="loading" class="muted">Cargando inventario...</p>
    <p v-if="message" class="success">{{ message }}</p>
    <p v-if="error" class="error">{{ error }}</p>

    <table v-if="!loading" class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.id">
          <td>{{ producto.id }}</td>
          <td>
            <img
              :src="producto.imagen_url || '/img/placeholder.png'"
              :alt="producto.nombre"
              class="thumb"
              @error="(e) => { e.target.src = '/img/placeholder.png' }"
            />
          </td>
          <td>{{ producto.nombre }}</td>
          <td>${{ Number(producto.precio).toFixed(2) }}</td>
          <td>{{ producto.stock }}</td>
          <td class="admin-actions">
            <RouterLink class="link" :to="`/catalogo/${producto.id}`">Detalle</RouterLink>
            <RouterLink class="link" :to="`/admin/editar/${producto.id}`">Editar</RouterLink>
            <button class="btn btn-danger" @click="borrar(producto.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
