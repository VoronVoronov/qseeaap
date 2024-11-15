import { defineStore } from 'pinia'

export const useAlertStore = defineStore('alert', {
    state: () => ({
        alert: {
            show: false,
            message: '',
            color: 'success',
            icon: ''
        }
    }),
    actions: {
        showAlert(message, color, icon) {
            this.hideAlert();
            this.alert.show = true
            this.alert.message = message
            this.alert.color = color
            this.alert.icon = icon
        },
        hideAlert() {
            this.alert.show = false
            this.alert.message = ''
            this.alert.color = 'success'
            this.alert.icon = ''
        }
    }
})

export default useAlertStore
