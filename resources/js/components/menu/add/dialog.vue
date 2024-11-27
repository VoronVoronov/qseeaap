<template>
    <v-dialog max-width="450px" v-model="showMenuDialog">
        <v-card>
            <v-card-title>{{ $t("menu.action.create") }}</v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="menu.name"
                    :label="$t('menu.form.name')"
                    outlined
                    @blur="v$.name.$touch"
                    @input="v$.name.$touch"
                    :error-messages="v$.name.$errors.map(e => e.$message)"
                    required
                />
                <v-textarea
                    v-model="menu.description"
                    :label="$t('menu.form.description')"
                    outlined
                />
                <div class="image-container">
                    <v-img v-if="menu.preview" :src="menu.preview" width="150" height="150">
                        <template v-slot:default>
                            <div class="overlay" @click="$refs.file.click()">
                                <v-icon large color="white">mdi-camera</v-icon>
                            </div>
                        </template>
                    </v-img>
                </div>
                <input type="file" style="display: none" ref="file" accept="image/png, image/jpeg, image/jpg" @change="onFileChange" />
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click="addMenu">{{ $t("menu.action.create") }}</v-btn>
                <v-btn color="error" @click="closeAddMenu()">{{ $t("menu.action.cancel") }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import { ref, defineEmits, reactive } from 'vue';
import { axiosRequest } from "../../../utils/helper";
import { Required } from '../../../utils/validator'
import { useVuelidate } from '@vuelidate/core'
import { useAlertStore } from '../../../stores/alertStore'
import i18n from '../../../i18n';

interface MenuItem {
    id: number;
    name: string;
    description: string;
    logo?: File | null;
    preview?: string | null;
}

const showMenuDialog = ref(false);
const emit = defineEmits(['showMenuDialog', 'getMenu'])
const alertStore = useAlertStore()
let selectedFile = reactive<File | null>(null);
const menu = reactive<MenuItem>({
    id: 0,
    name: '',
    description: '',
    logo: null,
    preview: 'https://placehold.co/150x150'
});

const rules = {
    name: {
        Required
    }
}

const v$ = useVuelidate(rules, menu)


function addMenu() {
    if (v$.value.$invalid) {
        v$.value.$touch()
        return
    }
    let form = new FormData();
    form.append('name', menu.name);
    form.append('description', menu.description);
    if (selectedFile instanceof File) {
        form.append('logo', selectedFile);
    }
    axiosRequest('user/menu', form, (json) => {
        if(json.id){
            alertStore.showAlert(i18n.global.t("menu.alert.success_created"), 'success', 'mdi-check')
            emit('getMenu')
            closeAddMenu()
        }else{
            alertStore.showAlert(i18n.global.t("menu.alert.error_created"), 'error', 'mdi-alert')
        }
    });
}

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

function closeAddMenu() {
    emit('showMenuDialog')
}
</script>
<style scoped>
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
