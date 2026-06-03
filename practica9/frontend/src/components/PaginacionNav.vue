<script setup>
const props = defineProps({
  meta: {
    type: Object,
    default: () => ({}),
  },
  loading: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['cambio-pagina'])

const ir = (pagina) => {
  if (!pagina || pagina < 1 || pagina > props.meta.last_page || props.loading) {
    return
  }

  emit('cambio-pagina', pagina)
}
</script>

<template>
  <div v-if="meta?.last_page > 1" class="pagination">
    <button class="btn btn-light" :disabled="loading || meta.current_page <= 1" @click="ir(1)">Primera</button>
    <button class="btn btn-light" :disabled="loading || meta.current_page <= 1" @click="ir(meta.current_page - 1)">Anterior</button>

    <span>Pagina {{ meta.current_page }} de {{ meta.last_page }}</span>

    <button class="btn btn-light" :disabled="loading || meta.current_page >= meta.last_page" @click="ir(meta.current_page + 1)">Siguiente</button>
    <button class="btn btn-light" :disabled="loading || meta.current_page >= meta.last_page" @click="ir(meta.last_page)">Ultima</button>
  </div>
</template>
