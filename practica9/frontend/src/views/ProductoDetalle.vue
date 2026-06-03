<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { getApiError, obtenerProducto } from '@/services/productoService'

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
})

const router = useRouter()
const producto = ref(null)
const loading = ref(false)
const error = ref('')

onMounted(async () => {
  loading.value = true
  error.value = ''

  try {
    producto.value = await obtenerProducto(props.id)
  } catch (err) {
    error.value = getApiError(err, 'Producto no encontrado.')
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main class="page">
    <section class="card">
      <button class="btn btn-light" @click="router.back()">Volver al catalogo</button>

      <p v-if="loading" class="muted">Cargando detalle...</p>
      <p v-else-if="error" class="error">{{ error }}</p>

      <article v-else-if="producto" class="detail">
        <img
          :src="producto.imagen_url || '/img/placeholder.png'"
          :alt="producto.nombre"
          class="producto-imagen detalle-imagen"
          @error="(e) => { e.target.src = '/img/placeholder.png' }"
        />
        <span v-if="producto.categoria?.nombre" class="category-badge">
          {{ producto.categoria.nombre }}
        </span>
        <h1>{{ producto.nombre }}</h1>
        <p>{{ producto.descripcion || 'Sin descripcion' }}</p>
        <p><strong>Precio:</strong> ${{ Number(producto.precio).toFixed(2) }}</p>
        <p><strong>Stock:</strong> {{ producto.stock }}</p>
      </article>
    </section>
  </main>
</template>
