<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import {
  actualizarProducto,
  getApiError,
  obtenerProducto,
} from '@/services/productoService'

const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
})

const router = useRouter()
const loading = ref(false)
const cargando = ref(false)
const error = ref('')
const success = ref('')

const form = reactive({
  nombre: '',
  descripcion: '',
  precio: '',
  stock: '',
})

const imagen = ref(null)
const preview = ref(null)

const onImageChange = (event) => {
  const file = event.target.files[0]

  if (!file) {
    imagen.value = null
    return
  }

  imagen.value = file
  preview.value = URL.createObjectURL(file)
}

const validar = () => {
  if (!form.nombre.trim()) {
    return 'El nombre es obligatorio.'
  }

  if (Number(form.precio) < 0 || Number.isNaN(Number(form.precio))) {
    return 'El precio debe ser un numero mayor o igual a 0.'
  }

  if (Number(form.stock) < 0 || Number.isNaN(Number(form.stock))) {
    return 'El stock debe ser un entero mayor o igual a 0.'
  }

  return ''
}

const cargar = async () => {
  cargando.value = true
  error.value = ''

  try {
    const producto = await obtenerProducto(props.id)
    form.nombre = producto.nombre
    form.descripcion = producto.descripcion || ''
    form.precio = producto.precio
    form.stock = producto.stock
    preview.value = producto.imagen_url || null
  } catch (err) {
    error.value = getApiError(err, 'No se pudo cargar el producto.')
  } finally {
    cargando.value = false
  }
}

const guardar = async () => {
  error.value = ''
  success.value = ''

  const msg = validar()
  if (msg) {
    error.value = msg
    return
  }

  const fd = new FormData()
  fd.append('nombre', form.nombre)
  fd.append('descripcion', form.descripcion)
  fd.append('precio', String(form.precio))
  fd.append('stock', String(form.stock))

  if (imagen.value) {
    fd.append('imagen', imagen.value)
  }

  loading.value = true

  try {
    await actualizarProducto(props.id, fd)
    success.value = 'Producto actualizado correctamente.'
    setTimeout(() => {
      success.value = ''
      router.push('/admin/productos')
    }, 1200)
  } catch (err) {
    error.value = getApiError(err, 'No se pudo actualizar el producto.')
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await cargar()
})
</script>

<template>
  <div>
    <h1>Editar producto</h1>
    <p v-if="cargando" class="muted">Cargando producto...</p>

    <form v-else class="form" @submit.prevent="guardar">
      <label>
        Nombre
        <input v-model="form.nombre" class="input" type="text" maxlength="255" />
      </label>

      <label>
        Descripcion
        <textarea v-model="form.descripcion" class="input" rows="3" />
      </label>

      <label>
        Precio
        <input v-model="form.precio" class="input" type="number" min="0" step="0.01" />
      </label>

      <label>
        Stock
        <input v-model="form.stock" class="input" type="number" min="0" step="1" />
      </label>

      <label>
        Reemplazar imagen
        <input class="input" type="file" accept="image/*" @change="onImageChange" />
      </label>

      <div v-if="preview" class="preview-wrap">
        <img :src="preview" alt="Preview" class="preview-img" />
      </div>

      <p v-if="error" class="error">{{ error }}</p>
      <p v-if="success" class="success">{{ success }}</p>

      <button class="btn" type="submit" :disabled="loading">
        {{ loading ? 'Guardando...' : 'Actualizar producto' }}
      </button>
    </form>
  </div>
</template>
