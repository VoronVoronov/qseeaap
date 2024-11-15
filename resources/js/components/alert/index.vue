<template>
    <v-alert
        v-model="alert.show"
        :color="alert.color"
        dense
        closable
        elevation="2"
        class="custom-alert animate__animated animate__slideInRight"
        :icon="alert.icon"
    >
        {{ alert.message }}
    </v-alert>
</template>

<script setup lang="ts">
import { computed, ref, watch, onUnmounted } from 'vue'
import { useAlertStore } from '../../stores/alertStore'

const store = useAlertStore()
const progress = ref(100)
let interval: ReturnType<typeof setInterval> | null = null

const alert = computed({
    get: () => store.alert,
    set: (val) => {
        store.alert.show = val.show
    }
})

watch(
    () => alert.value.show,
    (newVal) => {
        if (newVal) {
            progress.value = 60
            interval = setInterval(() => {
                if (progress.value > 0) {
                    progress.value -= 20
                } else {
                    store.alert.show = false
                    clearInterval(interval!)
                }
            }, 1000)
        } else if (interval) {
            clearInterval(interval)
            interval = null
        }
    }
)

onUnmounted(() => {
    if (interval) clearInterval(interval)
})
</script>

<style scoped>
.custom-alert {
    position: absolute;
    right: 5px;
    font-size: 16px;
    z-index: 9999999;
    top: 15px;
}
</style>
