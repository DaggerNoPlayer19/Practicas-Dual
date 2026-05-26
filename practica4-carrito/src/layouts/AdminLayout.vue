<script setup>
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const cerrarSesion = () => {
  auth.logout()
  router.push('/login')
}
</script>

<template>
  <main class="admin-layout">
    <aside class="sidebar">
      <h2>Panel Admin</h2>
      <p class="muted">Usuario: {{ auth.user?.name || 'Sin usuario' }}</p>

      <nav class="nav-col">
        <RouterLink to="/admin">Dashboard</RouterLink>
        <RouterLink to="/admin/productos">Gestionar productos</RouterLink>
        <RouterLink to="/admin/nuevo">Nuevo producto</RouterLink>
        <RouterLink to="/catalogo">Ver catálogo</RouterLink>
      </nav>

      <button class="btn btn-danger" @click="cerrarSesion">Cerrar sesión</button>
    </aside>

    <section class="admin-content card">
      <RouterView />
    </section>
  </main>
</template>

