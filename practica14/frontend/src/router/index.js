import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  { path: '/', name: 'home', component: () => import('@/views/HomeView.vue') },
  { path: '/catalogo', name: 'catalogo', component: () => import('@/views/CatalogoView.vue') },
  {
    path: '/catalogo/:id',
    name: 'producto-detalle',
    component: () => import('@/views/ProductoDetalle.vue'),
    props: true,
  },
  { path: '/carrito', name: 'carrito', component: () => import('@/views/CartView.vue') },
  { path: '/login', name: 'login', component: () => import('@/views/LoginView.vue') },
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true, requiresStaff: true },
    children: [
      { path: '', name: 'admin-dashboard', component: () => import('@/views/admin/Dashboard.vue') },
      { path: 'productos', name: 'admin-productos', component: () => import('@/views/admin/Productos.vue') },
      { path: 'nuevo', name: 'admin-nuevo', component: () => import('@/views/admin/NuevoProducto.vue') },
      {
        path: 'editar/:id',
        name: 'admin-editar',
        component: () => import('@/views/admin/EditarProducto.vue'),
        props: true,
      },
    ],
  },
  { path: '/404', name: 'not-found', component: () => import('@/views/NotFound.vue') },
  { path: '/:pathMatch(.*)*', redirect: '/404' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to) => {
  const auth = useAuthStore()

  if (auth.token && !auth.user) {
    await auth.fetchUser()
  }

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { path: '/login', query: { redirect: to.fullPath } }
  }

  if (to.meta.requiresStaff && !auth.isStaff) {
    return { path: '/catalogo' }
  }

  return true
})

export default router
