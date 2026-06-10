<script setup>
import { onBeforeUnmount, ref, watch } from 'vue'
import { getPedido } from '@/services/pedidoService'

const props = defineProps({
  pedidoId: {
    type: [Number, String],
    required: true,
  },
})

const pedido = ref(null)
const cargando = ref(true)
const error = ref('')
const intervalo = ref(null)

const detenerPolling = () => {
  if (intervalo.value) {
    clearInterval(intervalo.value)
    intervalo.value = null
  }
}

const cargarPedido = async () => {
  try {
    error.value = ''
    const data = await getPedido(props.pedidoId)
    pedido.value = data

    if (data?.email_enviado_at || data?.estado === 'completado' || data?.estado === 'cancelado') {
      detenerPolling()
    }
  } catch (e) {
    error.value = e?.response?.data?.message || 'No fue posible consultar el estado del pedido.'
    detenerPolling()
  } finally {
    cargando.value = false
  }
}

const iniciarPolling = () => {
  detenerPolling()
  intervalo.value = setInterval(cargarPedido, 3000)
}

watch(
  () => props.pedidoId,
  async (nuevoId) => {
    if (!nuevoId) {
      return
    }

    cargando.value = true
    await cargarPedido()
    if (!pedido.value?.email_enviado_at && pedido.value?.estado !== 'cancelado') {
      iniciarPolling()
    }
  },
  { immediate: true },
)

onBeforeUnmount(detenerPolling)
</script>

<template>
  <section class="card pedido-estado">
    <h2>Estado del pedido</h2>

    <p v-if="cargando">Procesando tu pedido...</p>
    <p v-else-if="error" class="error">{{ error }}</p>
    <template v-else>
      <p><strong>Pedido #{{ pedido.id }}</strong></p>
      <p v-if="pedido.estado === 'completado' || pedido.email_enviado_at">Pedido confirmado. Revisa tu correo.</p>
      <p v-else-if="pedido.estado === 'cancelado'">El pedido no pudo completarse.</p>
      <p v-else>Procesando tu pedido...</p>
      <p><strong>Estado:</strong> {{ pedido.estado }}</p>
      <p><strong>Total:</strong> ${{ Number(pedido.total).toFixed(2) }}</p>
      <p v-if="pedido.email_enviado_at"><strong>Email enviado:</strong> {{ new Date(pedido.email_enviado_at).toLocaleString() }}</p>
    </template>
  </section>
</template>
