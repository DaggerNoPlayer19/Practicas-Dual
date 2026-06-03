import { reactive, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const fromQuery = (query) => ({
  busqueda: String(query.busqueda || ''),
  categoria: String(query.categoria || ''),
  min: String(query.min || ''),
  max: String(query.max || ''),
  orden: String(query.orden || 'nombre'),
  dir: String(query.dir || 'asc'),
  pagina: Number(query.pagina || 1),
  por_pagina: Number(query.por_pagina || 15),
})

const toQuery = (filtros) => ({
  busqueda: filtros.busqueda || undefined,
  categoria: filtros.categoria || undefined,
  min: filtros.min || undefined,
  max: filtros.max || undefined,
  orden: filtros.orden !== 'nombre' ? filtros.orden : undefined,
  dir: filtros.dir !== 'asc' ? filtros.dir : undefined,
  pagina: filtros.pagina > 1 ? filtros.pagina : undefined,
  por_pagina: filtros.por_pagina !== 15 ? filtros.por_pagina : undefined,
})

export function useFiltros() {
  const route = useRoute()
  const router = useRouter()
  const filtros = reactive(fromQuery(route.query))
  let sincronizando = false

  watch(
    () => route.query,
    (query) => {
      sincronizando = true
      Object.assign(filtros, fromQuery(query))
      sincronizando = false
    },
    { immediate: true }
  )

  watch(
    filtros,
    () => {
      if (sincronizando) {
        return
      }

      router.replace({ query: toQuery(filtros) })
    },
    { deep: true }
  )

  const limpiar = () => {
    Object.assign(filtros, {
      busqueda: '',
      categoria: '',
      min: '',
      max: '',
      orden: 'nombre',
      dir: 'asc',
      pagina: 1,
      por_pagina: 15,
    })
  }

  return { filtros, limpiar }
}
