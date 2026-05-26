<script setup>
import { onMounted, ref } from 'vue'
import NavBar from '@/components/layout/NavBar.vue'
import ProductoForm from '@/components/productos/ProductoForm.vue'
import ProductosList from '@/components/productos/ProductosList.vue'
import { createProducto, deleteProducto, getProductos, updateProducto } from '@/services/productoService'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const productos = ref([])
const loading = ref(false)
const saving = ref(false)
const editingProducto = ref(null)
const successMessage = ref('')
const errorMessage = ref('')

const getErrorMessage = (error, fallback) => {
  if (error.response?.data?.message) {
    return error.response.data.message
  }

  const errors = error.response?.data?.errors
  if (errors) {
    const firstField = Object.keys(errors)[0]
    if (firstField && errors[firstField]?.[0]) {
      return errors[firstField][0]
    }
  }

  return fallback
}

const loadProductos = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    productos.value = await getProductos()
  } catch (error) {
    errorMessage.value = getErrorMessage(error, 'No se pudo cargar el listado de productos.')
  } finally {
    loading.value = false
  }
}

const handleSubmit = async (payload) => {
  saving.value = true
  successMessage.value = ''
  errorMessage.value = ''

  try {
    if (editingProducto.value?.id) {
      await updateProducto(editingProducto.value.id, payload)
      successMessage.value = 'Producto actualizado correctamente.'
    } else {
      await createProducto(payload)
      successMessage.value = 'Producto creado correctamente.'
    }

    editingProducto.value = null
    await loadProductos()
  } catch (error) {
    errorMessage.value = getErrorMessage(error, 'No se pudo guardar el producto.')
  } finally {
    saving.value = false
  }
}

const handleEdit = (producto) => {
  successMessage.value = ''
  errorMessage.value = ''
  editingProducto.value = { ...producto }
}

const handleCancelEdit = () => {
  editingProducto.value = null
}

const handleDelete = async (producto) => {
  const confirmed = confirm(`Deseas eliminar "${producto.nombre}"?`)
  if (!confirmed) {
    return
  }

  successMessage.value = ''
  errorMessage.value = ''

  try {
    await deleteProducto(producto.id)
    successMessage.value = 'Producto eliminado correctamente.'
    await loadProductos()
  } catch (error) {
    errorMessage.value = getErrorMessage(error, 'No se pudo eliminar el producto.')
  }
}

onMounted(async () => {
  await auth.fetchMe()
  await loadProductos()
})
</script>

<template>
  <main class="dashboard-page">
    <NavBar />

    <section class="dashboard-grid">
      <ProductoForm :producto="editingProducto" :loading="saving" @submit="handleSubmit" @cancel="handleCancelEdit" />

      <div>
        <p v-if="successMessage" class="alert success">{{ successMessage }}</p>
        <p v-if="errorMessage" class="alert error">{{ errorMessage }}</p>

        <ProductosList :productos="productos" :loading="loading" @edit="handleEdit" @delete="handleDelete" />
      </div>
    </section>
  </main>
</template>
