<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import { createEcho } from '@/plugins/echo'

const notifications = ref([])
const echo = ref(null)
const timeouts = new Map()

const pushNotification = (notification) => {
  const id = `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`
  notifications.value = [{ id, ...notification }, ...notifications.value].slice(0, 6)

  const timeoutId = window.setTimeout(() => {
    notifications.value = notifications.value.filter((item) => item.id !== id)
    timeouts.delete(id)
  }, 9000)

  timeouts.set(id, timeoutId)
}

const stats = computed(() => ({
  total: notifications.value.length,
  pedidos: notifications.value.filter((item) => item.type === 'pedido').length,
  stock: notifications.value.filter((item) => item.type === 'stock').length,
}))

onMounted(() => {
  echo.value = createEcho()

  echo.value
    .private('admin-panel')
    .listen('NuevoPedidoRecibido', (event) => {
      pushNotification({
        type: 'pedido',
        title: `Nuevo pedido #${event.id}`,
        message: `${event.cliente} generó un pedido de $${Number(event.total).toFixed(2)} (${event.items} productos).`,
        meta: event.created_at,
      })
    })
    .listen('StockBajoAlerta', (event) => {
      pushNotification({
        type: 'stock',
        title: 'Stock bajo',
        message: `${event.nombre} quedó con ${event.stock_actual} unidades.`,
        meta: `Producto #${event.producto_id}`,
      })
    })
})

onBeforeUnmount(() => {
  if (echo.value) {
    echo.value.leave('admin-panel')
    echo.value.disconnect()
    echo.value = null
  }

  timeouts.forEach((timeoutId) => window.clearTimeout(timeoutId))
  timeouts.clear()
})
</script>

<template>
  <aside class="live-notifications card">
    <div class="live-notifications__header">
      <div>
        <p class="eyebrow">Tiempo real</p>
        <h3>Alertas de Reverb</h3>
      </div>
      <span class="live-badge">Activo</span>
    </div>

    <p class="muted">
      Pedidos nuevos y alertas de stock aparecen sin recargar la pagina.
    </p>

    <div class="live-stats">
      <div>
        <strong>{{ stats.total }}</strong>
        <span>Total</span>
      </div>
      <div>
        <strong>{{ stats.pedidos }}</strong>
        <span>Pedidos</span>
      </div>
      <div>
        <strong>{{ stats.stock }}</strong>
        <span>Stock</span>
      </div>
    </div>

    <TransitionGroup name="toast" tag="ul" class="notification-list">
      <li v-for="item in notifications" :key="item.id" :class="['notification-item', item.type]">
        <div class="notification-item__title">{{ item.title }}</div>
        <div class="notification-item__message">{{ item.message }}</div>
        <small class="notification-item__meta">{{ item.meta }}</small>
      </li>
    </TransitionGroup>

    <p v-if="!notifications.length" class="muted notification-empty">
      Esperando eventos en vivo...
    </p>
  </aside>
</template>
