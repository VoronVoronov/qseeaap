<template>
    <v-card>
        <v-tabs
            v-model="tab"
            bg-color="primary"
        >
            <template v-for="item in tabs">
                <v-tab :value="item.name">
                    {{ item.title }}
                </v-tab>
            </template>
        </v-tabs>

        <v-card-text>
            <v-tabs-window v-model="tab">
                <template v-for="item in tabs">
                    <v-tabs-window-item :value="item.name">
                        <component :is="item.component" :id="id" />
                    </v-tabs-window-item>
                </template>
            </v-tabs-window>
        </v-card-text>
    </v-card>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import mainSettings from '../../components/menu/edit/mainSettingsTab.vue';
import tariffTab from '../../components/menu/edit/tariffTab.vue';
import categoryIndex from '../../components/menu/edit/category/indexCategory.vue';
import i18n from '../../i18n/index';
import { useRouter } from 'vue-router'

const router = useRouter()
const tabs = ref([
    { name: 'mainSettings', title: i18n.global.t("menu.tab.mainSettings"), component: mainSettings },
    { name: 'tariffTab', title: i18n.global.t("menu.tab.tariffTab"), component: tariffTab },
    { name: 'categoryIndex', title: i18n.global.t("menu.tab.categories"), component: categoryIndex },
]);

const tab = ref('one');
const id = router.currentRoute.value.params.id;
</script>
