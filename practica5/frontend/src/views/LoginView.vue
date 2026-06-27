<script setup>
import { reactive, ref } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const route = useRoute()
const router = useRouter()

const form = reactive({
  email: 'admin@tienda.com',
  password: 'Admin1234',
  token_type: 'write',
})

const notice = ref('')

const onSubmit = async () => {
  notice.value = ''
  const ok = await auth.login(form)

  if (!ok) {
    return
  }

  notice.value = 'Sesion iniciada correctamente.'
  setTimeout(() => {
    notice.value = ''
  }, 2500)

  const redirect = route.query.redirect || '/admin'
  router.push(redirect)
}
</script>

<template>
  <main class="page page-center">
    <section class="card auth-card">
      <h1>Iniciar sesion</h1>
      <p class="muted">Acceso con Sanctum. Usuario demo admin precargado.</p>
      <p class="muted">Email: admin@tienda.com | Password: Admin1234</p>
      <p class="muted">Token por defecto: escritura. Cambia a solo lectura para probar permisos limitados.</p>
      <p v-if="route.query.redirect" class="muted">Redireccion pendiente: {{ route.query.redirect }}</p>

      <form class="form" @submit.prevent="onSubmit">
        <label>
          Tipo de token
          <select v-model="form.token_type" class="input">
            <option value="read">Solo lectura</option>
            <option value="write">Escritura</option>
          </select>
        </label>
        <label>
          Correo
          <input v-model="form.email" class="input" type="email" required />
        </label>
        <label>
          Password
          <input v-model="form.password" class="input" type="password" required minlength="8" />
        </label>

        <p v-if="auth.error" class="error">{{ auth.error }}</p>
        <p v-if="notice" class="success">{{ notice }}</p>

        <button class="btn" type="submit" :disabled="auth.loading">
          {{ auth.loading ? 'Ingresando...' : 'Entrar' }}
        </button>
      </form>

      <RouterLink class="link" to="/">Volver al inicio</RouterLink>
    </section>
  </main>
</template>
