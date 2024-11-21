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
    <v-img class="mb-5" :src="menu.preview" width="150" height="150"></v-img>
    <input type="file" style="display: none" ref="file" @change="onFileChange" />
    <div class="button-group">
        <v-btn @click="$refs.file.click()" color="primary">{{ $t('menu.form.change_logo') }}</v-btn>
        <v-btn
            @click="submit"
            color="primary"
        >
            {{ $t('menu.action.save') }}
        </v-btn>
    </div>
</template>

<script setup lang="ts">
import {ref, defineProps, onMounted, reactive} from 'vue';
import { axiosGetRequest, axiosPutRequest } from "../../../utils/helper";
import { useAlertStore } from '../../../stores/alertStore';
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
const preview = ref<string | null>(null);
const file = ref<File | null>(null);

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
    logo: null,
    preview: null,
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
        menu.logo = null;
        menu.preview = response.data.logo;
    });
};

onMounted(() => {
    getMenu();
});

function onFileChange(event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        const selectedFile = input.files[0];
        file.value = selectedFile;
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target?.result as string;
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
    form.append('name', menu.name);
    form.append('description', menu.description);
    if (file.value instanceof File) {
        form.append('logo', file.value);
    }
    axiosPutRequest(`user/menu/${props.id}`, form, (response) => {
        if (response.menu && response.menu.id) {
            alertStore.showAlert(i18n.global.t('menu.alert.success_updated'), 'success', 'mdi-check');
        } else {
            alertStore.showAlert(i18n.global.t('menu.alert.error_updated'), 'error', 'mdi-alert');
        }
    });
}

</script>


<style scoped>
.button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
</style>
