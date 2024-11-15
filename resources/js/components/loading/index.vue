<template>
    <v-progress-circular
        v-if="props.loading"
        indeterminate
        :size="props.size"
        :width="props.width"
        style="position: absolute;
           z-index: 9999999999;
           top: 50%;
           left: 50%;
           transform: translate(-50%, -50%);"
    />
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    size: {
        type: Number,
        default: 128
    },
    width: {
        type: Number,
        default: 12
    }
})
</script>

<style scoped>
</style>
