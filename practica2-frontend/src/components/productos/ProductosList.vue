<script setup>
defineProps({
  productos: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['edit', 'delete'])
</script>

<template>
  <section class="card list-card">
    <div class="list-head">
      <h2>Productos</h2>
      <span v-if="loading">Cargando...</span>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.id">
          <td>{{ producto.id }}</td>
          <td>{{ producto.nombre }}</td>
          <td>{{ producto.descripcion || '-' }}</td>
          <td>${{ Number(producto.precio).toFixed(2) }}</td>
          <td>{{ producto.stock }}</td>
          <td class="row-actions">
            <button class="secondary" @click="emit('edit', producto)">Editar</button>
            <button class="danger" @click="emit('delete', producto)">Eliminar</button>
          </td>
        </tr>

        <tr v-if="!loading && productos.length === 0">
          <td colspan="6" class="empty">No hay productos registrados.</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>
