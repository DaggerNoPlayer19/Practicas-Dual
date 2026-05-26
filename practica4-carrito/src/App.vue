<script setup>
import { RouterLink, useRoute } from 'vue-router'
import CartIcon from '@/components/CartIcon.vue'

const route = useRoute()
</script>

<template>
  <header class="topbar" v-if="!route.path.startsWith('/admin')">
    <div class="topbar-inner">
      <RouterLink to="/" class="brand">Practica 04 · Carrito Pinia</RouterLink>
      <nav class="top-links">
        <RouterLink to="/">Inicio</RouterLink>
        <RouterLink to="/catalogo">Catalogo</RouterLink>
        <RouterLink to="/carrito">Carrito</RouterLink>
        <RouterLink to="/admin">Admin</RouterLink>
      </nav>
      <CartIcon />
    </div>
  </header>

  <router-view />
</template>
