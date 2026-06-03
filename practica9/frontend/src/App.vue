<script setup>
import { computed } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import CartIcon from '@/components/CartIcon.vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const isLogged = computed(() => auth.isAuthenticated)

const cerrarSesion = async () => {
  await auth.logout()
  router.push('/login')
}
</script>

<template>
  <header class="topbar">
    <div class="topbar-inner">
      <RouterLink to="/" class="brand">Practica 09 - Validaciones Avanzadas</RouterLink>

      <nav class="top-links">
        <RouterLink to="/">Inicio</RouterLink>
        <RouterLink to="/catalogo">Catalogo</RouterLink>
        <RouterLink to="/carrito">Carrito</RouterLink>
        <RouterLink v-if="auth.isStaff" to="/admin">Admin</RouterLink>
      </nav>

      <div class="top-right">
        <CartIcon />
        <RouterLink v-if="!isLogged" class="btn btn-light" to="/login">Login</RouterLink>
        <button v-else class="btn btn-light" @click="cerrarSesion">Salir</button>
      </div>
    </div>
  </header>

  <router-view />
</template>
