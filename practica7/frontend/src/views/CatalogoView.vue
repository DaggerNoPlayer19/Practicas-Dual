<script setup>
import { onMounted, ref, watch } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import FiltrosPanel from '@/components/FiltrosPanel.vue'
import PaginacionNav from '@/components/PaginacionNav.vue'
import { useCarritoStore } from '@/stores/carrito'
import { getApiError, obtenerCategorias, obtenerProductos } from '@/services/productoService'
import { useFiltros } from '@/composables/useFiltros'

const route = useRoute()
const carrito = useCarritoStore()
const { filtros, limpiar } = useFiltros()

const categorias = ref([])
const resultado = ref({ data: [], meta: {} })
const loadingCategorias = ref(false)
const loading = ref(false)
const error = ref('')

const cargarCategorias = async () => {
  loadingCategorias.value = true

  try {
    const { data } = await obtenerCategorias()
    categorias.value = data
  } catch (err) {
    error.value = getApiError(err, 'No fue posible cargar categorias.')
  } finally {
    loadingCategorias.value = false
  }
}

const cargarProductos = async () => {
  loading.value = true
  error.value = ''

  try {
    const { data, meta } = await obtenerProductos({
      busqueda: route.query.busqueda || '',
      categoria: route.query.categoria || '',
      min: route.query.min || '',
      max: route.query.max || '',
      orden: route.query.orden || 'nombre',
      dir: route.query.dir || 'asc',
      pagina: route.query.pagina || 1,
      por_pagina: route.query.por_pagina || 15,
    })

    resultado.value = { data, meta }
  } catch (err) {
    error.value = getApiError(err, 'No fue posible cargar catalogo.')
  } finally {
    loading.value = false
  }
}

const actualizarFiltros = (nuevosFiltros) => {
  Object.assign(filtros, nuevosFiltros)
}

const limpiarFiltros = () => {
  limpiar()
}

watch(
  () => route.query,
  () => {
    cargarProductos()
  },
  { deep: true, immediate: true }
)

onMounted(async () => {
  await cargarCategorias()
})
</script>

<template>
  <main class="page catalog-layout">
    <section class="card">
      <div class="row-between">
        <h1>Catalogo con filtros</h1>
        <RouterLink class="link" to="/">Volver a inicio</RouterLink>
      </div>

      <div class="catalog-grid">
        <FiltrosPanel
          :categorias="categorias"
          :model-value="filtros"
          @update:modelValue="actualizarFiltros"
          @limpiar="limpiarFiltros"
        />

        <section class="catalog-results">
          <p v-if="loadingCategorias" class="muted">Cargando categorias...</p>
          <p v-if="loading" class="muted">Cargando productos...</p>
          <p v-else-if="error" class="error">{{ error }}</p>

          <div v-else class="grid-products">
            <article v-for="producto in resultado.data" :key="producto.id" class="product-card">
              <img
                :src="producto.imagen_url || '/img/placeholder.png'"
                :alt="producto.nombre"
                class="producto-imagen"
                @error="(e) => { e.target.src = '/img/placeholder.png' }"
              />

              <span v-if="producto.categoria?.nombre" class="category-badge">
                {{ producto.categoria.nombre }}
              </span>

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

          <PaginacionNav
            :meta="resultado.meta"
            :loading="loading"
            @cambio-pagina="(pagina) => (filtros.pagina = pagina)"
          />
        </section>
      </div>
    </section>
  </main>
</template>
