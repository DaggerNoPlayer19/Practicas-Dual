<script setup>
import { RouterLink, useRouter } from 'vue-router'
import { useCarritoStore } from '@/stores/carrito'

const router = useRouter()
const carrito = useCarritoStore()

const decrementar = (item) => {
  carrito.cambiarCantidad(item.id, item.cantidad - 1)
}

const incrementar = (item) => {
  carrito.cambiarCantidad(item.id, item.cantidad + 1)
}

const vaciarCarrito = () => {
  const confirmado = confirm('¿Deseas vaciar el carrito completo?')
  if (!confirmado) {
    return
  }

  carrito.vaciar()
}

const finalizarCompra = () => {
  if (carrito.totalItems === 0) {
    alert('Tu carrito está vacío.')
    return
  }

  alert(`Compra finalizada. Total: $${carrito.totalPrecio.toFixed(2)}`)
  carrito.vaciar()
  router.push('/catalogo')
}
</script>

<template>
  <main class="page">
    <section class="card">
      <div class="row-between">
        <h1>Carrito de compras</h1>
        <RouterLink class="link" to="/catalogo">Seguir comprando</RouterLink>
      </div>

      <p v-if="carrito.items.length === 0">No hay productos en el carrito.</p>

      <div v-else class="cart-grid">
        <article v-for="item in carrito.items" :key="item.id" class="cart-item">
          <div class="cart-info">
            <h3>{{ item.nombre }}</h3>
            <p>Precio unitario: ${{ Number(item.precio).toFixed(2) }}</p>
            <p>Subtotal: ${{ Number(item.precio * item.cantidad).toFixed(2) }}</p>
          </div>

          <div class="cart-actions">
            <button class="btn btn-light" @click="decrementar(item)">-</button>
            <span class="qty">{{ item.cantidad }}</span>
            <button class="btn btn-light" @click="incrementar(item)">+</button>
            <button class="btn btn-danger" @click="carrito.quitar(item.id)">×</button>
          </div>
        </article>

        <section class="cart-summary card">
          <p><strong>Total de items:</strong> {{ carrito.totalItems }}</p>
          <p><strong>Total general:</strong> ${{ carrito.totalPrecio.toFixed(2) }}</p>
          <div class="summary-actions">
            <button class="btn btn-danger" @click="vaciarCarrito">Vaciar carrito</button>
            <button class="btn" @click="finalizarCompra">Finalizar compra</button>
          </div>
        </section>
      </div>
    </section>
  </main>
</template>
