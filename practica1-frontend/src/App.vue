<script setup>
import { onMounted, ref } from 'vue'
import ProductoForm from './components/ProductoForm.vue'
import ProductosList from './components/ProductosList.vue'
import {
  createProducto,
  deleteProducto,
  getProductos,
  updateProducto,
} from './services/productoService'

const productos = ref([])
const loadingList = ref(false)
const saving = ref(false)
const editingId = ref(null)
const flash = ref({ type: '', text: '' })

const formData = ref({
  nombre: '',
  descripcion: '',
  precio: '',
  stock: '',
})

const loadProductos = async () => {
  loadingList.value = true
  try {
    const { data } = await getProductos()
    productos.value = data
  } catch {
    flash.value = { type: 'error', text: 'No se pudo cargar la lista de productos.' }
  } finally {
    loadingList.value = false
  }
}

const clearForm = () => {
  editingId.value = null
  formData.value = {
    nombre: '',
    descripcion: '',
    precio: '',
    stock: '',
  }
}

const handleSubmit = async (payload) => {
  saving.value = true
  flash.value = { type: '', text: '' }

  try {
    if (editingId.value) {
      await updateProducto(editingId.value, payload)
      flash.value = { type: 'success', text: 'Producto actualizado correctamente.' }
    } else {
      await createProducto(payload)
      flash.value = { type: 'success', text: 'Producto creado correctamente.' }
    }

    await loadProductos()
    clearForm()
  } catch (error) {
    const validationErrors = error?.response?.data?.errors
    if (validationErrors) {
      const firstError = Object.values(validationErrors)[0]?.[0]
      flash.value = { type: 'error', text: firstError ?? 'Error de validación.' }
    } else {
      flash.value = { type: 'error', text: 'No se pudo guardar el producto.' }
    }
  } finally {
    saving.value = false
  }
}

const handleEdit = (producto) => {
  editingId.value = producto.id
  formData.value = {
    nombre: producto.nombre,
    descripcion: producto.descripcion ?? '',
    precio: producto.precio,
    stock: producto.stock,
  }
  flash.value = { type: '', text: '' }
}

const handleDelete = async (producto) => {
  const ok = window.confirm(`¿Eliminar "${producto.nombre}"?`)
  if (!ok) return

  try {
    await deleteProducto(producto.id)
    flash.value = { type: 'success', text: 'Producto eliminado correctamente.' }
    await loadProductos()
  } catch {
    flash.value = { type: 'error', text: 'No se pudo eliminar el producto.' }
  }
}

onMounted(() => {
  loadProductos()
})
</script>

<template>
  <main class="container">
    <h1>CRUD de Productos</h1>
    <p class="subtitle">Laravel API REST + Vue.js con Axios</p>

    <p v-if="flash.text" :class="['flash', flash.type]">{{ flash.text }}</p>

    <ProductoForm
      :initial-data="formData"
      :editing="Boolean(editingId)"
      :loading="saving"
      @submit="handleSubmit"
      @cancel="clearForm"
    />

    <ProductosList
      :productos="productos"
      :loading="loadingList"
      @edit="handleEdit"
      @delete="handleDelete"
    />
  </main>
</template>
