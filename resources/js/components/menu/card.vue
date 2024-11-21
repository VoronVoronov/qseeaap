<template>
    <v-card
        width="340"
        hover
    >
        <v-img
            height="250"
            :src="item.logo ? item.logo : 'https://via.placeholder.com/250'"
            cover
        ></v-img>
        <v-card-item>
            <v-card-title>{{ item.name }}</v-card-title>
        </v-card-item>
        <v-card-text>
            <div>{{ item.description }}</div>
        </v-card-text>
        <v-card-actions>
            <v-btn
                prepend-icon="mdi-pencil"
                color="primary"
                border
                @click="editMenu(item.id)"
            >
                {{ $t('menu.action.edit') }}
            </v-btn>
            <v-btn
                prepend-icon="mdi-delete"
                color="red"
                border
                @click="deleteMenu(item.id)"
            >
                {{ $t('menu.action.delete') }}
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import { axiosDeleteRequest } from "../../utils/helper";
import { useAlertStore } from '../../stores/alertStore'
import i18n from '../../i18n';
import { useRouter } from 'vue-router'

const alertStore = useAlertStore()
const emit = defineEmits(['deleteMenu'])
const router = useRouter()

interface MenuItem {
    id: number;
    name: string;
    description: string;
    logo?: string;
}

defineProps({
    item: {
        type: Object as () => MenuItem,
        required: true,
    }
});


function deleteMenu(id: number) {
    axiosDeleteRequest(`user/menu/${id}`, (json) => {
        if(json.success) {
            alertStore.showAlert(json.message, 'success', 'mdi-alert-circle')
            emit('deleteMenu')
        }else{
            alertStore.showAlert(i18n.global.t("system.error"), 'error', 'mdi-alert-circle')
        }
    });
}

function editMenu(id){
    router.push({ name: 'menu.edit', params: { id: id } })
}
</script>
