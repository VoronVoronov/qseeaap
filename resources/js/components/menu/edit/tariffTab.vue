<template>
    <PricingCards :current_tariff="menu.tariff_id" />
</template>
<script setup lang="ts">
import { useCurrentMenuStore } from '../../../stores/currentMenuStore';
import PricingCards from '../PricingCards.vue';
const currentMenuStore = useCurrentMenuStore();
const menu = currentMenuStore.getMenu();
</script>
