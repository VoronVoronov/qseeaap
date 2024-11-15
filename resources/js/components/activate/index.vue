<template>
    <v-sheet
        class="pt-8 pb-12 px-6 ma-4 mx-auto"
        max-width="350"
        width="100%"
        border
        style="position: absolute;
            z-index: 9999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);"
    >
        <h3 class="text-h6 mb-1">{{ $t("sms.user_activate.title") }}</h3>

        <div class="text-body-2 font-weight-light">
            {{ $t("sms.user_activate.text") }} <span class="font-weight-black text-primary">{{phone}}</span>
        </div>

        <v-otp-input
            v-model="code"
            class="mt-3 ms-n2"
            length="4"
            placeholder="0"
            variant="underlined"
        ></v-otp-input>

        <v-divider class="mt-3 mb-6"></v-divider>

        <div class="mb-3 text-body-2">
            {{ $t("sms.need_code") }}
        </div>

        <v-btn
            color="primary"
            size="small"
            :text="$t('sms.resend_code')"
            variant="tonal"
            @click="resendCode()"
        />
    </v-sheet>
</template>
<script setup lang="ts">
import { ref, watch, defineEmits } from 'vue';
import { axiosRequest } from "../../utils/helper";
import { useAlertStore } from '../../stores/alertStore'
const alertStore = useAlertStore()
const emit = defineEmits(['activation-success'])

const code = ref('');
const phone = localStorage.getItem('phone');

watch(code, (value) => {
    if (value.length === 4) {
        axiosRequest('user/check-code', { phone: phone, code: value }, (json) => {
            if(json.data) {
                alertStore.showAlert(json.data.message, 'error', 'mdi-alert-circle');
            }else{
                alertStore.showAlert(json.message, 'success', 'mdi-check-circle');
                emit('activation-success')
            }

            setTimeout(() => {
                alertStore.hideAlert()
            }, 5000)
        });
    }
});

const resendCode = () => {
    axiosRequest('user/send-sms', { phone: phone }, (json) => {
        if(json.data) {
            alertStore.showAlert(json.data.message, 'error', 'mdi-alert-circle');
        }else{
            alertStore.showAlert(json.message, 'success', 'mdi-check-circle');
        }
        setTimeout(() => {
            alertStore.hideAlert()
        }, 5000)
    });
}

</script>
