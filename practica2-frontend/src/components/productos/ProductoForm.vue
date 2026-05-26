<script setup>
import { computed, reactive, watch } from 'vue'

const props = defineProps({
  producto: {
    type: Object,
    default: null,
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
  precio: 0,
  stock: 0,
})

const isEditing = computed(() => Boolean(props.producto?.id))

const fillForm = (producto) => {
  form.nombre = producto?.nombre ?? ''
  form.descripcion = producto?.descripcion ?? ''
  form.precio = producto?.precio ?? 0
  form.stock = producto?.stock ?? 0
}

watch(
  () => props.producto,
  (value) => {
    fillForm(value)
  },
  { immediate: true },
)

const onSubmit = () => {
  emit('submit', {
    nombre: form.nombre,
    descripcion: form.descripcion || null,
    precio: Number(form.precio),
    stock: Number(form.stock),
  })
}

const onCancel = () => {
  emit('cancel')
}
</script>

<template>
  <section class="card form-card">
    <h2>{{ isEditing ? 'Editar producto' : 'Nuevo producto' }}</h2>

    <form class="form-grid" @submit.prevent="onSubmit">
      <label>
        Nombre
        <input v-model="form.nombre" type="text" required maxlength="255" />
      </label>

      <label>
        Descripcion
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
        <button type="submit" :disabled="loading">
          {{ loading ? 'Guardando...' : isEditing ? 'Actualizar' : 'Crear' }}
        </button>
        <button v-if="isEditing" type="button" class="secondary" :disabled="loading" @click="onCancel">
          Cancelar edicion
        </button>
      </div>
    </form>
  </section>
</template>
