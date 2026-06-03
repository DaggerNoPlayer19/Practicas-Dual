<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useField, useForm } from 'vee-validate'
import InputField from '@/components/InputField.vue'
import { productoSchema } from '@/schemas/productoSchema'
import { crearProducto, getApiError, obtenerCategorias } from '@/services/productoService'

const router = useRouter()
const loading = ref(false)
const cargandoCategorias = ref(false)
const categorias = ref([])
const error = ref('')
const success = ref('')
const erroresServidor = ref({})
const imagen = ref(null)
const preview = ref(null)

const { handleSubmit, resetForm } = useForm({
  validationSchema: productoSchema,
  initialValues: {
    nombre: '',
    descripcion: '',
    precio: '',
    stock: '',
    categoria_id: '',
  },
})

const { value: nombre, errorMessage: nombreError, handleBlur: blurNombre } = useField('nombre')
const { value: descripcion, errorMessage: descripcionError, handleBlur: blurDescripcion } = useField('descripcion')
const { value: precio, errorMessage: precioError, handleBlur: blurPrecio } = useField('precio')
const { value: stock, errorMessage: stockError, handleBlur: blurStock } = useField('stock')
const { value: categoriaId, errorMessage: categoriaError, handleBlur: blurCategoria } = useField('categoria_id')

const cargarCategorias = async () => {
  cargandoCategorias.value = true

  try {
    const { data } = await obtenerCategorias()
    categorias.value = data
  } catch (err) {
    error.value = getApiError(err, 'No se pudieron cargar las categorias.')
  } finally {
    cargandoCategorias.value = false
  }
}

const onImageChange = (file) => {
  imagen.value = file
  preview.value = file ? URL.createObjectURL(file) : null
}

const guardar = handleSubmit(async (values) => {
  error.value = ''
  success.value = ''
  erroresServidor.value = {}

  const fd = new FormData()
  fd.append('nombre', values.nombre)
  fd.append('descripcion', values.descripcion || '')
  fd.append('precio', String(values.precio))
  fd.append('stock', String(values.stock))
  fd.append('categoria_id', values.categoria_id || '')

  if (imagen.value) {
    fd.append('imagen', imagen.value)
  }

  loading.value = true

  try {
    await crearProducto(fd)
    success.value = 'Producto creado correctamente.'
    resetForm()
    imagen.value = null
    preview.value = null
    setTimeout(() => {
      success.value = ''
      router.push('/admin/productos')
    }, 1200)
  } catch (err) {
    if (err.response?.status === 422) {
      erroresServidor.value = err.response.data.errors || {}
      error.value = 'Revisa los campos marcados.'
      return
    }

    error.value = getApiError(err, 'No se pudo crear el producto.')
  } finally {
    loading.value = false
  }
})

onMounted(async () => {
  await cargarCategorias()
})
</script>

<template>
  <div>
    <h1>Nuevo producto</h1>
    <p v-if="cargandoCategorias" class="muted">Cargando categorias...</p>

    <form v-else class="form" @submit.prevent="guardar">
      <InputField
        v-model="nombre"
        :error="nombreError || erroresServidor.nombre?.[0]"
        label="Nombre"
        placeholder="Escribe el nombre"
        @blur="blurNombre"
      />

      <InputField
        v-model="descripcion"
        :error="descripcionError || erroresServidor.descripcion?.[0]"
        as="textarea"
        label="Descripcion"
        placeholder="Descripcion opcional"
        rows="3"
        @blur="blurDescripcion"
      />

      <InputField
        v-model="categoriaId"
        :error="categoriaError || erroresServidor.categoria_id?.[0]"
        as="select"
        label="Categoria"
        @blur="blurCategoria"
      >
        <option value="">Sin categoria</option>
        <option v-for="categoria in categorias" :key="categoria.id" :value="String(categoria.id)">
          {{ categoria.nombre }}
        </option>
      </InputField>

      <InputField
        v-model="precio"
        :error="precioError || erroresServidor.precio?.[0]"
        label="Precio"
        type="number"
        min="0"
        step="0.01"
        placeholder="0.00"
        @blur="blurPrecio"
      />

      <InputField
        v-model="stock"
        :error="stockError || erroresServidor.stock?.[0]"
        label="Stock"
        type="number"
        min="0"
        step="1"
        placeholder="0"
        @blur="blurStock"
      />

      <InputField
        :error="erroresServidor.imagen?.[0] || ''"
        label="Imagen de portada"
        type="file"
        accept="image/*"
        @update:modelValue="onImageChange"
      />

      <div v-if="preview" class="preview-wrap">
        <img :src="preview" alt="Preview" class="preview-img" />
      </div>

      <p v-if="error" class="error">{{ error }}</p>
      <p v-if="success" class="success">{{ success }}</p>

      <button v-can="'crear'" class="btn" type="submit" :disabled="loading">
        {{ loading ? 'Guardando...' : 'Guardar producto' }}
      </button>
    </form>
  </div>
</template>
