<script setup>
import { computed, reactive, watch } from 'vue'

const props = defineProps({
  initialData: {
    type: Object,
    default: () => ({
      nombre: '',
      descripcion: '',
      precio: '',
      stock: '',
    }),
  },
  editing: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['submit', 'cancel'])

const form = reactive({
  nombre: '',
  descripcion: '',
  precio: '',
  stock: '',
})

watch(
  () => props.initialData,
  (value) => {
    form.nombre = value.nombre ?? ''
    form.descripcion = value.descripcion ?? ''
    form.precio = value.precio ?? ''
    form.stock = value.stock ?? ''
  },
  { immediate: true, deep: true },
)

const title = computed(() => (props.editing ? 'Editar producto' : 'Crear producto'))
const buttonLabel = computed(() => (props.editing ? 'Actualizar' : 'Guardar'))

const onSubmit = () => {
  emit('submit', {
    nombre: form.nombre,
    descripcion: form.descripcion,
    precio: form.precio,
    stock: form.stock,
  })
}
</script>

<template>
  <section class="card">
    <h2>{{ title }}</h2>
    <form @submit.prevent="onSubmit" class="form-grid">
      <label>
        Nombre
        <input v-model="form.nombre" type="text" required />
      </label>

      <label>
        Descripción
        <textarea v-model="form.descripcion" rows="3" />
      </label>

      <label>
        Precio
        <input v-model.number="form.precio" type="number" min="0" step="0.01" required />
      </label>

      <label>
        Stock
        <input v-model.number="form.stock" type="number" min="0" step="1" required />
      </label>

      <div class="actions">
        <button type="submit" :disabled="loading">{{ buttonLabel }}</button>
        <button v-if="editing" type="button" class="secondary" @click="$emit('cancel')" :disabled="loading">
          Cancelar
        </button>
      </div>
    </form>
  </section>
</template>
