<script setup>
const props = defineProps({
  producto: {
    type: Object,
    required: true,
  },
  cantidadEnCarrito: {
    type: Number,
    default: 0,
  },
})

const emit = defineEmits(['agregar-carrito'])

const formatPrecio = (precio) => `$${Number(precio).toFixed(2)}`
</script>

<template>
  <article class="product-card">
    <img
      :src="producto.imagen_url || '/img/placeholder.png'"
      :alt="producto.nombre"
      class="producto-imagen"
      @error="(e) => { e.target.src = '/img/placeholder.png' }"
    />

    <span v-if="producto.categoria?.nombre" class="category-badge">
      {{ producto.categoria.nombre }}
    </span>

    <h3>{{ producto.nombre }}</h3>
    <p>{{ producto.descripcion || 'Sin descripcion' }}</p>
    <span>Stock: {{ producto.stock }}</span>
    <strong>{{ formatPrecio(producto.precio) }}</strong>

    <div class="product-actions">
      <RouterLink class="link" :to="`/catalogo/${producto.id}`">Detalle</RouterLink>
      <button
        class="btn"
        data-test="btn-agregar"
        @click="$emit('agregar-carrito', producto)"
      >
        <template v-if="cantidadEnCarrito > 0">
          En carrito ({{ cantidadEnCarrito }})
        </template>
        <template v-else>
          Agregar al carrito
        </template>
      </button>
    </div>
  </article>
</template>
