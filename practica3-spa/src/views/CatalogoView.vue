<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { obtenerProductos } from '@/services/productoService'

const productos = ref([])
const busqueda = ref('')
const loading = ref(false)
const error = ref('')

const productosFiltrados = computed(() =>
  productos.value.filter((p) => p.nombre.toLowerCase().includes(busqueda.value.toLowerCase())),
)

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    productos.value = await obtenerProductos()
  } catch {
    error.value = 'No fue posible cargar el catálogo.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main class="page">
    <section class="card">
      <div class="row-between">
        <h1>Catálogo</h1>
        <RouterLink class="link" to="/">Volver a inicio</RouterLink>
      </div>

      <input v-model="busqueda" class="input" type="text" placeholder="Buscar por nombre..." />

      <p v-if="loading">Cargando productos...</p>
      <p v-else-if="error" class="error">{{ error }}</p>
      <div v-else class="grid-products">
        <article v-for="producto in productosFiltrados" :key="producto.id" class="product-card">
          <h3>{{ producto.nombre }}</h3>
          <p>{{ producto.descripcion || 'Sin descripción' }}</p>
          <span>Stock: {{ producto.stock }}</span>
          <strong>${{ Number(producto.precio).toFixed(2) }}</strong>
          <RouterLink class="link" :to="`/catalogo/${producto.id}`">Ver detalle</RouterLink>
        </article>
      </div>
    </section>
  </main>
</template>

