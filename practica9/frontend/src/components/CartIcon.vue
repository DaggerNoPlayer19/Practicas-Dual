<script setup>
import { RouterLink } from 'vue-router'
import { useCarritoStore } from '@/stores/carrito'

const carrito = useCarritoStore()
</script>

<template>
  <RouterLink to="/carrito" class="cart-link" aria-label="Ir al carrito">
    <span class="cart-icon">
      🛒
      <span v-if="carrito.totalItems > 0" class="badge">{{ carrito.totalItems }}</span>
    </span>
  </RouterLink>
</template>
