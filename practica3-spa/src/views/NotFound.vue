<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <main class="page page-center">
    <section class="card auth-card">
      <h1>Error 404</h1>
      <p>La ruta solicitada no existe.</p>
      <RouterLink class="btn" to="/">Volver a inicio</RouterLink>
    </section>
  </main>
</template>

