<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const logout = async () => {
  await auth.logout()
  router.push({ name: 'login' })
}
</script>

<template>
  <nav class="top-nav">
    <div>
      <strong>Practica 02 - Laravel Sanctum</strong>
      <p v-if="auth.user" class="muted">Sesion: {{ auth.user.name }} ({{ auth.user.email }})</p>
    </div>

    <button class="secondary" :disabled="auth.loading" @click="logout">
      {{ auth.loading ? 'Saliendo...' : 'Cerrar sesion' }}
    </button>
  </nav>
</template>
