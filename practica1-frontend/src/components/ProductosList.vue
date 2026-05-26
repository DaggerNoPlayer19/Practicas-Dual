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

defineEmits(['edit', 'delete'])
</script>

<template>
  <section class="card">
    <h2>Listado de productos</h2>
    <p v-if="loading">Cargando productos...</p>
    <div v-else class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="producto in productos" :key="producto.id">
            <td>{{ producto.id }}</td>
            <td>{{ producto.nombre }}</td>
            <td>{{ producto.descripcion || 'Sin descripción' }}</td>
            <td>${{ Number(producto.precio).toFixed(2) }}</td>
            <td>{{ producto.stock }}</td>
            <td class="row-actions">
              <button type="button" @click="$emit('edit', producto)">Editar</button>
              <button type="button" class="danger" @click="$emit('delete', producto)">Eliminar</button>
            </td>
          </tr>
          <tr v-if="productos.length === 0">
            <td colspan="6" class="empty">No hay productos registrados.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>
