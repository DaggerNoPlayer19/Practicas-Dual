<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = async () => {
  const ok = await auth.register(form)
  if (ok) {
    router.push({ name: 'dashboard' })
  }
}
</script>

<template>
  <main class="auth-page">
    <section class="card auth-card">
      <h1>Registro</h1>
      <p class="muted">Crea tu cuenta para obtener token de acceso.</p>

      <form class="form-grid" @submit.prevent="submit">
        <label>
          Nombre
          <input v-model="form.name" type="text" required />
        </label>

        <label>
          Correo
          <input v-model="form.email" type="email" required />
        </label>

        <label>
          Contrasena
          <input v-model="form.password" type="password" required minlength="8" />
        </label>

        <label>
          Confirmar contrasena
          <input v-model="form.password_confirmation" type="password" required minlength="8" />
        </label>

        <p v-if="auth.error" class="alert error">{{ auth.error }}</p>

        <button type="submit" :disabled="auth.loading">
          {{ auth.loading ? 'Registrando...' : 'Registrar' }}
        </button>
      </form>

      <router-link class="link" :to="{ name: 'login' }">Ya tengo cuenta</router-link>
    </section>
  </main>
</template>
