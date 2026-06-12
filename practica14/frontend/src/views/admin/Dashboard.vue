<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const permisos = computed(() => [
  { key: 'crear', label: 'Crear' },
  { key: 'editar', label: 'Editar' },
  { key: 'eliminar', label: 'Eliminar' },
])
</script>

<template>
  <div>
    <h1>Dashboard</h1>
    <p>Panel privado protegido por Sanctum, Gates, Policies y directivas Vue.</p>
    <p class="muted">Usuario activo: {{ auth.user?.name || '-' }} | Rol: {{ auth.rol }}</p>

    <div class="permission-grid">
      <div v-for="permiso in permisos" :key="permiso.key" class="permission-card">
        <strong>{{ permiso.label }}</strong>
        <span :class="auth.can(permiso.key) ? 'pill pill-ok' : 'pill pill-off'">
          {{ auth.can(permiso.key) ? 'Permitido' : 'Bloqueado' }}
        </span>
      </div>
    </div>
  </div>
</template>
