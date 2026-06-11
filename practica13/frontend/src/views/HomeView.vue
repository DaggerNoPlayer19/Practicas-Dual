<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useCarritoStore } from '@/stores/carrito'
import { obtenerProductos } from '@/services/productoService'

const carrito = useCarritoStore()
const productos = ref([])
const loading = ref(false)
const error = ref('')

const ultimosTres = computed(() => productos.value.slice(0, 3))

onMounted(async () => {
  loading.value = true
  error.value = ''

  try {
    const { data } = await obtenerProductos({ page: 1, perPage: 10 })
    productos.value = data
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
      <h1>Práctica 13</h1>
      <p>API versionada con Laravel y Swagger: documentación formal, compatibilidad y consumo desde Vue.</p>
      <div class="hero-actions">
        <RouterLink class="btn" to="/catalogo">Ver catálogo</RouterLink>
        <RouterLink class="btn btn-light" to="/carrito">Ver carrito</RouterLink>
      </div>
    </section>

    <section class="card">
      <h2>Productos recientes</h2>
      <p v-if="loading" class="muted">Cargando productos...</p>
      <p v-else-if="error" class="error">{{ error }}</p>

      <div v-else class="grid-products">
        <article v-for="producto in ultimosTres" :key="producto.id" class="product-card">
          <img
            :src="producto.imagen_url || '/img/placeholder.png'"
            :alt="producto.nombre"
            class="producto-imagen"
            @error="(e) => { e.target.src = '/img/placeholder.png' }"
          />
          <h3>{{ producto.nombre }}</h3>
          <p>{{ producto.descripcion || 'Sin descripción' }}</p>
          <strong>${{ Number(producto.precio).toFixed(2) }}</strong>

          <div class="product-actions">
            <RouterLink class="link" :to="`/catalogo/${producto.id}`">Detalle</RouterLink>
            <button class="btn" @click="carrito.agregar(producto)">Agregar</button>
          </div>
        </article>
      </div>
    </section>
  </main>
</template>
