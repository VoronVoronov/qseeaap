<template>
    <v-text-field
        :label="$t('menu.form.name')"
        v-model="menu.name"
        @blur="v$.name.$touch"
        @input="v$.name.$touch"
        :error-messages="v$.name.$errors.map(e => e.$message)"
    ></v-text-field>

    <v-textarea
        v-model="menu.description"
        :label="$t('menu.form.description')"
    />
    <div class="image-container">
        <v-img class="mb-5" :src="menu.preview" width="150" height="150">
            <template v-slot:default>
                <div class="overlay" @click="$refs.file.click()">
                    <v-icon large color="white">mdi-camera</v-icon>
                </div>
            </template>
        </v-img>
    </div>
    <input type="file" style="display: none" ref="file" @change="onFileChange" />
    <div class="button-group">
        <v-btn
            @click="submit"
            color="primary"
        >
            {{ $t('menu.action.save') }}
        </v-btn>
    </div>
</template>

<script setup lang="ts">
import {defineProps, onMounted, reactive} from 'vue';
import { axiosGetRequest, axiosRequest } from "../../../utils/helper";
import { useAlertStore } from '../../../stores/alertStore';
import { useCurrentMenuStore } from '../../../stores/currentMenuStore';
import i18n from '../../../i18n/index';
import { useVuelidate } from '@vuelidate/core'
import { Required } from '../../../utils/validator'

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});
const alertStore = useAlertStore();
const currentMenuStore = useCurrentMenuStore();
let selectedFile = reactive<File | null>(null);

interface MenuItem {
    id: number;
    name: string;
    description: string;
    logo?: File | null;
    preview?: string | null;
}

const menu = reactive<MenuItem>({
    id: 0,
    name: '',
    description: '',
    preview: null,
    logo: null,
});

const rules = {
    name: {
        Required
    }
}

const v$ = useVuelidate(rules, menu)

const getMenu = () => {
    axiosGetRequest(`user/menu/${props.id}`, (response) => {
        menu.id = response.data.id;
        menu.name = response.data.name;
        menu.description = response.data.description;
        menu.preview = response.data.logo;
        currentMenuStore.setMenu(response.data);
    });
};

onMounted(() => {
    getMenu();
});

function onFileChange(file: File | Event) {

    if (file instanceof Event) {
        const input = file.target as HTMLInputElement;
        if (input.files && input.files.length > 0) {
            selectedFile = input.files[0];
        }
    } else if (file instanceof File) {
        selectedFile = file;
    }

    if (selectedFile) {
        menu.logo = selectedFile;
        const reader = new FileReader();
        reader.onload = (e) => {
            menu.preview = e.target?.result as string;
        };
        reader.readAsDataURL(selectedFile);
    }
}

function submit() {
    if (v$.value.$invalid) {
        v$.value.$touch()
        return
    }

    let form = new FormData();
    form.append('_method', 'PUT');
    form.append('name', menu.name);
    form.append('description', menu.description);
    if (selectedFile instanceof File) {
        form.append('logo', selectedFile);
    }
    axiosRequest(`user/menu/${props.id}`, form, (response) => {
        if (response.menu && response.menu.id) {
            getMenu();
            alertStore.showAlert(i18n.global.t('menu.alert.success_updated'), 'success', 'mdi-check');
        }else if(response.message){
            alertStore.showAlert(response.message, 'error', 'mdi-alert');
        } else {
            alertStore.showAlert(i18n.global.t('menu.alert.error_updated'), 'error', 'mdi-alert');
        }
    });
}

</script>

<style scoped>
.button-group {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.image-container {
    position: relative;
    width: 150px;
    height: 150px;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}
.image-container:hover .overlay {
    opacity: 1;
}
</style>
