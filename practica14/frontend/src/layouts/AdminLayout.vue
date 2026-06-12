<script setup>
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const cerrarSesion = async () => {
  await auth.logout()
  router.push('/login')
}
</script>

<template>
  <main class="admin-layout">
    <aside class="sidebar">
      <h2>Panel de gestion</h2>
      <p class="muted">Usuario: {{ auth.user?.name || '-' }}</p>
      <p class="muted">Rol: {{ auth.user?.rol || 'cliente' }}</p>

      <nav class="nav-col">
        <RouterLink to="/admin">Dashboard</RouterLink>
        <RouterLink to="/admin/productos">Gestion de productos</RouterLink>
        <RouterLink to="/admin/nuevo">Nuevo producto</RouterLink>
        <RouterLink to="/catalogo">Ver catalogo</RouterLink>
      </nav>

      <button class="btn btn-danger" @click="cerrarSesion">Cerrar sesion</button>
    </aside>

    <section class="admin-content card">
      <RouterView />
    </section>
  </main>
</template>
