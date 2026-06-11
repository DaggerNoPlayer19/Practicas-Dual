<script setup>
import { computed, onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useCarritoStore } from '@/stores/carrito'
import { getApiError, obtenerProductos } from '@/services/productoService'

const carrito = useCarritoStore()

const productos = ref([])
const busqueda = ref('')
const loading = ref(false)
const error = ref('')

const page = ref(1)
const lastPage = ref(1)
const perPage = 10

const productosFiltrados = computed(() => {
  return productos.value.filter((item) => {
    return item.nombre.toLowerCase().includes(busqueda.value.trim().toLowerCase())
  })
})

const cargar = async (targetPage = 1) => {
  loading.value = true
  error.value = ''

  try {
    const { data, meta } = await obtenerProductos({ page: targetPage, perPage })
    productos.value = data
    page.value = meta?.current_page ?? targetPage
    lastPage.value = meta?.last_page ?? 1
  } catch (err) {
    error.value = getApiError(err, 'No fue posible cargar catalogo.')
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await cargar(1)
})
</script>

<template>
  <main class="page">
    <section class="card">
      <div class="row-between">
        <h1>Catalogo</h1>
        <RouterLink class="link" to="/">Volver a inicio</RouterLink>
      </div>

      <input v-model="busqueda" class="input" type="text" placeholder="Buscar por nombre..." />

      <p v-if="loading" class="muted">Cargando productos...</p>
      <p v-else-if="error" class="error">{{ error }}</p>

      <div v-else class="grid-products">
        <article v-for="producto in productosFiltrados" :key="producto.id" class="product-card">
          <img
            :src="producto.imagen_url || '/img/placeholder.png'"
            :alt="producto.nombre"
            class="producto-imagen"
            @error="(e) => { e.target.src = '/img/placeholder.png' }"
          />

          <h3>{{ producto.nombre }}</h3>
          <p>{{ producto.descripcion || 'Sin descripcion' }}</p>
          <span>Stock: {{ producto.stock }}</span>
          <strong>${{ Number(producto.precio).toFixed(2) }}</strong>

          <div class="product-actions">
            <RouterLink class="link" :to="`/catalogo/${producto.id}`">Ver detalle</RouterLink>
            <button class="btn" @click="carrito.agregar(producto)">
              <template v-if="carrito.cantidadDeProducto(producto.id) > 0">
                En carrito ({{ carrito.cantidadDeProducto(producto.id) }})
              </template>
              <template v-else>
                Agregar al carrito
              </template>
            </button>
          </div>
        </article>
      </div>

      <div class="pagination" v-if="lastPage > 1">
        <button class="btn btn-light" :disabled="page === 1 || loading" @click="cargar(page - 1)">Anterior</button>
        <span>Pagina {{ page }} de {{ lastPage }}</span>
        <button class="btn btn-light" :disabled="page === lastPage || loading" @click="cargar(page + 1)">Siguiente</button>
      </div>
    </section>
  </main>
</template>
