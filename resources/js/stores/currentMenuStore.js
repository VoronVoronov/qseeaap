import { defineStore } from 'pinia'

export const useCurrentMenuStore = defineStore('currentMenu', {
    state: () => ({
        menu: {}
    }),
    actions: {
        setMenu(menu) {
            this.menu = menu
        },
        getMenu() {
            return this.menu
        }
    }
})

export default useCurrentMenuStore
