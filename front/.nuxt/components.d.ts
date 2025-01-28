
import type { DefineComponent, SlotsType } from 'vue'
type IslandComponent<T extends DefineComponent> = T & DefineComponent<{}, {refresh: () => Promise<void>}, {}, {}, {}, {}, {}, {}, {}, {}, {}, {}, SlotsType<{ fallback: { error: unknown } }>>
interface _GlobalComponents {
      'Navbar': typeof import("../components/navbar.vue")['default']
      'LazyNavbar': typeof import("../components/navbar.vue")['default']
}

declare module 'vue' {
  export interface GlobalComponents extends _GlobalComponents { }
}

export const Navbar: typeof import("../components/navbar.vue")['default']
export const LazyNavbar: typeof import("../components/navbar.vue")['default']

export const componentNames: string[]
