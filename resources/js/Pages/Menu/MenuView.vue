<template>
    <v-btn v-if="menu.length > 0" class="mb-5" color="primary" @click="showMenuDialog = true">{{ $t("menu.action.create") }}</v-btn>
    <div class="d-flex justify-content-between gap-10 flex-wrap">
        <template v-for="item in menu">
            <MenuCard :item="item" @deleteMenu="handleGetMenu" />
        </template>
        <v-card v-if="menu.length == 0">
            <v-card-title>{{ $t("menu.empty.title") }}</v-card-title>
            <v-card-text>
                {{ $t("menu.empty.text") }}
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click="showMenuDialog = true">{{ $t("menu.action.create") }}</v-btn>
            </v-card-actions>
        </v-card>
        <AddDialog v-model="showMenuDialog" @showMenuDialog="handleShowMenuDialog" @getMenu="handleGetMenu" />
    </div>
</template>

<script setup lang="ts">
import MenuCard from '../../components/menu/card.vue'
import AddDialog from '../../components/menu/add/dialog.vue'
import { ref, onMounted } from 'vue';
import { axiosGetRequest } from "../../utils/helper";

const menu = ref([]);
const showMenuDialog = ref(false);

const getMenu = () => {
    axiosGetRequest('user/menu', (response) => {
        menu.value = response.data;
    });
};

onMounted(() => {
    getMenu();
});

const handleShowMenuDialog = () => {
    showMenuDialog.value = false;
}

const handleGetMenu = () => {
    getMenu();
}
</script>
<style scoped>
.gap-10{
    gap: 10px;
}
</style>
