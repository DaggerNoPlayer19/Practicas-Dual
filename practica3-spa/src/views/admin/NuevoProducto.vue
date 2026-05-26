<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { crearProducto } from '@/services/productoService'

const router = useRouter()
const loading = ref(false)
const error = ref('')
const success = ref('')

const form = reactive({
  nombre: '',
  descripcion: '',
  precio: 0,
  stock: 0,
})

const guardar = async () => {
  loading.value = true
  error.value = ''
  success.value = ''

  try {
    await crearProducto({
      nombre: form.nombre,
      descripcion: form.descripcion || null,
      precio: Number(form.precio),
      stock: Number(form.stock),
    })

    success.value = 'Producto creado correctamente.'
    router.push('/admin/productos')
  } catch {
    error.value = 'No se pudo crear el producto.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <h1>Nuevo producto</h1>

    <form class="form" @submit.prevent="guardar">
      <label>
        Nombre
        <input v-model="form.nombre" class="input" type="text" required />
      </label>
      <label>
        Descripción
        <textarea v-model="form.descripcion" class="input" rows="3" />
      </label>
      <label>
        Precio
        <input v-model.number="form.precio" class="input" type="number" min="0" step="0.01" required />
      </label>
      <label>
        Stock
        <input v-model.number="form.stock" class="input" type="number" min="0" step="1" required />
      </label>

      <p v-if="error" class="error">{{ error }}</p>
      <p v-if="success" class="success">{{ success }}</p>

      <button class="btn" type="submit" :disabled="loading">
        {{ loading ? 'Guardando...' : 'Guardar' }}
      </button>
    </form>
  </div>
</template>

