import { watchEffect } from 'vue'
import { useAuthStore } from '@/stores/auth'

const aplicarPermiso = (el, permiso) => {
  const auth = useAuthStore()

  if (el.__vCanStop) {
    el.__vCanStop()
  }

  el.__vCanStop = watchEffect(() => {
    el.style.display = auth.can(permiso) ? '' : 'none'
  })
}

export const vCan = {
  mounted(el, binding) {
    aplicarPermiso(el, binding.value)
  },

  updated(el, binding) {
    aplicarPermiso(el, binding.value)
  },

  unmounted(el) {
    if (el.__vCanStop) {
      el.__vCanStop()
    }
  },
}
