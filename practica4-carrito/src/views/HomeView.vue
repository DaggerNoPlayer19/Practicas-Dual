<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { obtenerProductos } from '@/services/productoService'
import { useCarritoStore } from '@/stores/carrito'

const carrito = useCarritoStore()
const productos = ref([])
const loading = ref(false)
const error = ref('')

const ultimosTres = computed(() => productos.value.slice(0, 3))

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    productos.value = await obtenerProductos()
  } catch {
    error.value = 'No fue posible cargar productos desde la API.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main class="page">
    <section class="hero card">
      <h1>Tienda Vue SPA</h1>
      <p>
        Navegación con Vue Router 4 sin recargar la página, conectada a la API de Laravel.
      </p>
      <div class="hero-actions">
        <RouterLink class="btn" to="/catalogo">Ver catálogo</RouterLink>
        <RouterLink class="btn btn-light" to="/carrito">Ver carrito</RouterLink>
      </div>
    </section>

    <section class="card">
      <h2>Últimos productos</h2>
      <p v-if="loading">Cargando productos...</p>
      <p v-else-if="error" class="error">{{ error }}</p>
      <div v-else class="grid-products">
        <article v-for="producto in ultimosTres" :key="producto.id" class="product-card">
          <h3>{{ producto.nombre }}</h3>
          <p>{{ producto.descripcion || 'Sin descripción' }}</p>
          <strong>${{ Number(producto.precio).toFixed(2) }}</strong>
          <div class="product-actions">
            <RouterLink class="link" :to="`/catalogo/${producto.id}`">Ver detalle</RouterLink>
            <button class="btn" @click="carrito.agregar(producto)">Agregar al carrito</button>
          </div>
        </article>
      </div>
    </section>
  </main>
</template>
