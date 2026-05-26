<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const form = reactive({
  email: '',
  password: '',
})

const submit = async () => {
  const ok = await auth.login(form)
  if (ok) {
    router.push({ name: 'dashboard' })
  }
}
</script>

<template>
  <main class="auth-page">
    <section class="card auth-card">
      <h1>Iniciar sesion</h1>
      <p class="muted">Accede para administrar productos protegidos con Sanctum.</p>

      <form class="form-grid" @submit.prevent="submit">
        <label>
          Correo
          <input v-model="form.email" type="email" required />
        </label>

        <label>
          Contrasena
          <input v-model="form.password" type="password" required minlength="8" />
        </label>

        <p v-if="auth.error" class="alert error">{{ auth.error }}</p>

        <button type="submit" :disabled="auth.loading">
          {{ auth.loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>

      <router-link class="link" :to="{ name: 'register' }">Crear cuenta nueva</router-link>
    </section>
  </main>
</template>
