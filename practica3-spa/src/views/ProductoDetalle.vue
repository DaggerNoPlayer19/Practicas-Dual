<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { obtenerProducto } from '@/services/productoService'

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
  } catch {
    error.value = 'Producto no encontrado o error al consultar API.'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main class="page">
    <section class="card">
      <button class="btn btn-light" @click="router.back()">Volver al catálogo</button>

      <p v-if="loading">Cargando detalle...</p>
      <p v-else-if="error" class="error">{{ error }}</p>
      <article v-else-if="producto" class="detail">
        <h1>{{ producto.nombre }}</h1>
        <p><strong>ID:</strong> {{ producto.id }}</p>
        <p>{{ producto.descripcion || 'Sin descripción' }}</p>
        <p><strong>Precio:</strong> ${{ Number(producto.precio).toFixed(2) }}</p>
        <p><strong>Stock:</strong> {{ producto.stock }}</p>
      </article>
    </section>
  </main>
</template>

