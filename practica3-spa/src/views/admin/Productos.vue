<script setup>
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { obtenerProductos } from '@/services/productoService'

const productos = ref([])
const loading = ref(false)
const error = ref('')

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    productos.value = await obtenerProductos()
  } catch {
    error.value = 'No fue posible cargar productos de inventario.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div>
    <div class="row-between">
      <h1>Gestión de productos</h1>
      <RouterLink class="btn" to="/admin/nuevo">Nuevo producto</RouterLink>
    </div>

    <p v-if="loading">Cargando inventario...</p>
    <p v-else-if="error" class="error">{{ error }}</p>

    <table v-else class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Stock</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.id">
          <td>{{ producto.id }}</td>
          <td>{{ producto.nombre }}</td>
          <td>${{ Number(producto.precio).toFixed(2) }}</td>
          <td>{{ producto.stock }}</td>
          <td>
            <RouterLink class="link" :to="`/catalogo/${producto.id}`">Detalle</RouterLink>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

