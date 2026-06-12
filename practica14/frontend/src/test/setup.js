import { config } from '@vue/test-utils'

config.global.stubs = {
  RouterLink: {
    template: '<a><slot /></a>',
  },
  RouterView: {
    template: '<div />',
  },
}

config.global.directives = {
  can: {
    mounted() {},
    updated() {},
  },
}
