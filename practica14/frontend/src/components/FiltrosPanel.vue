<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
  categorias: {
    type: Array,
    default: () => [],
  },
  modelValue: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['update:modelValue', 'limpiar'])

const local = reactive({
  busqueda: '',
  categoria: '',
  min: '',
  max: '',
  orden: 'nombre',
  dir: 'asc',
  pagina: 1,
  por_pagina: 15,
})

let timer = null

const syncFromProps = () => {
  Object.assign(local, props.modelValue)
  if (local.orden === 'precio') {
    local.orden = local.dir === 'desc' ? 'precio_desc' : 'precio_asc'
  }
}

watch(
  () => props.modelValue,
  () => {
    syncFromProps()
  },
  { deep: true, immediate: true }
)

const emitChange = (payload = {}, resetPage = true) => {
  const ordenSeleccionado = payload.orden || local.orden
  const dirSeleccionada = ordenSeleccionado === 'precio_desc'
    ? 'desc'
    : ordenSeleccionado === 'precio_asc'
      ? 'asc'
      : local.dir

  if (resetPage) {
    payload.pagina = 1
  }

  emit('update:modelValue', {
    ...local,
    orden: ordenSeleccionado === 'precio_asc' || ordenSeleccionado === 'precio_desc' ? 'precio' : ordenSeleccionado,
    dir: dirSeleccionada,
    ...payload,
  })
}

const onBusquedaInput = () => {
  clearTimeout(timer)
  timer = setTimeout(() => {
    emitChange({ busqueda: local.busqueda })
  }, 300)
}

const onSelectChange = () => {
  if (local.orden === 'nombre' || local.orden === 'precio_asc') {
    local.dir = 'asc'
  }

  if (local.orden === 'precio_desc') {
    local.dir = 'desc'
  }

  emitChange({})
}

const limpiar = () => {
  emit('limpiar')
}
</script>

<template>
  <aside class="filters-panel">
    <h3>Filtros</h3>

    <label>
      Buscar
      <input
        v-model="local.busqueda"
        class="input"
        type="text"
        placeholder="Nombre o descripcion"
        @input="onBusquedaInput"
      />
    </label>

    <label>
      Categoria
      <select v-model="local.categoria" class="input" @change="onSelectChange">
        <option value="">Todas</option>
        <option v-for="categoria in categorias" :key="categoria.id" :value="String(categoria.id)">
          {{ categoria.nombre }}
        </option>
      </select>
    </label>

    <div class="filters-grid">
      <label>
        Precio minimo
        <input v-model="local.min" class="input" type="number" min="0" step="0.01" @input="onSelectChange" />
      </label>

      <label>
        Precio maximo
        <input v-model="local.max" class="input" type="number" min="0" step="0.01" @input="onSelectChange" />
      </label>
    </div>

    <label>
      Orden
      <select v-model="local.orden" class="input" @change="onSelectChange">
        <option value="nombre">Nombre A-Z</option>
        <option value="precio_asc">Precio menor</option>
        <option value="precio_desc">Precio mayor</option>
      </select>
    </label>

    <label>
      Direccion
      <select v-model="local.dir" class="input" @change="onSelectChange">
        <option value="asc">Ascendente</option>
        <option value="desc">Descendente</option>
      </select>
    </label>

    <button class="btn btn-light" type="button" @click="limpiar">Limpiar filtros</button>
  </aside>
</template>
