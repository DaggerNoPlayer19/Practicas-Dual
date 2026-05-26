<script setup>
import { reactive } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const route = useRoute()
const router = useRouter()

const form = reactive({
  email: '',
  password: '',
})

const onSubmit = async () => {
  const ok = await auth.login(form)
  if (ok) {
    const redirect = route.query.redirect || '/admin'
    router.push(redirect)
  }
}
</script>

<template>
  <main class="page page-center">
    <section class="card auth-card">
      <h1>Iniciar sesión</h1>
      <p>Ruta pública de acceso al panel privado.</p>
      <p v-if="route.query.redirect" class="muted">
        Redirección pendiente: {{ route.query.redirect }}
      </p>

      <form class="form" @submit.prevent="onSubmit">
        <label>
          Correo
          <input v-model="form.email" class="input" type="email" required />
        </label>
        <label>
          Contraseña
          <input v-model="form.password" class="input" type="password" required />
        </label>

        <p v-if="auth.error" class="error">{{ auth.error }}</p>

        <button class="btn" type="submit" :disabled="auth.loading">
          {{ auth.loading ? 'Ingresando...' : 'Entrar' }}
        </button>
      </form>

      <RouterLink class="link" to="/">Volver a Home</RouterLink>
    </section>
  </main>
</template>

