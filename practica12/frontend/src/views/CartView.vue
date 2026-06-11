<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useCarritoStore } from '@/stores/carrito'
import { createPedido } from '@/services/pedidoService'
import PedidoEstado from '@/components/PedidoEstado.vue'

const carrito = useCarritoStore()
const pedidoId = ref(null)
const mensaje = ref('')
const error = ref('')
const enviando = ref(false)

const decrementar = (item) => {
  carrito.cambiarCantidad(item.id, item.cantidad - 1)
}

const incrementar = (item) => {
  carrito.cambiarCantidad(item.id, item.cantidad + 1)
}

const vaciarCarrito = () => {
  const ok = confirm('Deseas vaciar el carrito completo?')
  if (!ok) {
    return
  }

  carrito.vaciar()
}

const finalizarCompra = async () => {
  if (carrito.totalItems === 0) {
    error.value = 'Tu carrito esta vacio.'
    return
  }

  enviando.value = true
  mensaje.value = ''
  error.value = ''

  try {
    const payload = carrito.items.map((item) => ({
      id: item.id,
      cantidad: item.cantidad,
    }))

    const response = await createPedido(payload)
    pedidoId.value = response.id
    mensaje.value = 'Pedido registrado correctamente. El correo se enviara en cuanto la cola procese el job.'
    carrito.vaciar()
  } catch (e) {
    error.value = e?.response?.data?.message || 'No se pudo finalizar la compra.'
  } finally {
    enviando.value = false
  }
}
</script>

<template>
  <main class="page">
    <section class="card">
      <div class="row-between">
        <h1>Carrito de compras</h1>
        <RouterLink class="link" to="/catalogo">Seguir comprando</RouterLink>
      </div>

      <p v-if="mensaje" class="success">{{ mensaje }}</p>
      <p v-if="error" class="error">{{ error }}</p>

      <p v-if="carrito.items.length === 0">No hay productos en el carrito.</p>

      <div v-else class="cart-grid">
        <article v-for="item in carrito.items" :key="item.id" class="cart-item">
          <img
            :src="item.imagen_url || '/img/placeholder.png'"
            :alt="item.nombre"
            class="producto-imagen cart-imagen"
            @error="(e) => { e.target.src = '/img/placeholder.png' }"
          />

          <div class="cart-info">
            <h3>{{ item.nombre }}</h3>
            <p>Precio unitario: ${{ Number(item.precio).toFixed(2) }}</p>
            <p>Subtotal: ${{ Number(item.precio * item.cantidad).toFixed(2) }}</p>
          </div>

          <div class="cart-actions">
            <button class="btn btn-light" @click="decrementar(item)">-</button>
            <span class="qty">{{ item.cantidad }}</span>
            <button class="btn btn-light" @click="incrementar(item)">+</button>
            <button class="btn btn-danger" @click="carrito.quitar(item.id)">x</button>
          </div>
        </article>

        <section class="cart-summary card">
          <p><strong>Total de items:</strong> {{ carrito.totalItems }}</p>
          <p><strong>Total general:</strong> ${{ carrito.totalPrecio.toFixed(2) }}</p>
          <div class="summary-actions">
            <button class="btn btn-danger" @click="vaciarCarrito">Vaciar carrito</button>
            <button class="btn" :disabled="enviando" @click="finalizarCompra">
              {{ enviando ? 'Procesando...' : 'Finalizar compra' }}
            </button>
          </div>
        </section>
      </div>

      <PedidoEstado v-if="pedidoId" :pedido-id="pedidoId" />
    </section>
  </main>
</template>
