<template>
    <v-row
        align="center"
        no-gutters
        justify="center"
        style="height: 75vh;"
    >
        <v-card width="450px">
            <v-card-title>{{ $t('auth.restore_password') }}</v-card-title>
            <v-card-text>
                <form>
                    <v-text-field
                        v-maska="'+7 (###) ###-##-##'"
                        v-model="state.phone"
                        :error-messages="v$.phone.$errors.map(e => e.$message)"
                        :label="$t('auth.form.phone')"
                        required
                        @blur="v$.phone.$touch"
                        @input="v$.phone.$touch"
                    />

                    <v-btn
                        class="me-4"
                        @click="restore()"
                    >
                        {{ $t('auth.form.reset_password') }}
                    </v-btn>
                    <v-btn @click="gotoLogin()">
                        {{ $t('auth.form.login_btn') }}
                    </v-btn>
                </form>
            </v-card-text>
        </v-card>
    </v-row>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { vMaska } from "maska/vue"
import { useRouter } from 'vue-router'
import axios from 'axios'
import { url_api } from '../../utils/helper'
import { useAlertStore } from '../../stores/alertStore'
import { Required } from '../../utils/validator'

const router = useRouter()
const alertStore = useAlertStore()

const initialState = {
    phone: '',
}

const state = reactive({
    ...initialState,
})

const rules = {
    phone: {
        Required
    },
}

const v$ = useVuelidate(rules, state)

function clear () {
    v$.value.$reset()

    for (const [key, value] of Object.entries(initialState)) {
        state[key] = value
    }
}

function gotoLogin () {
    clear()
    router.push({ name: 'login' })
}

function restore(){
    if (v$.value.$invalid) {
        v$.value.$touch()
        return
    }

    axios.post(`${url_api}user/reset-password`, state)
        .then((response) => {
            alertStore.showAlert(response.data.message, 'success', 'mdi-check-circle')
            clear()
        })
        .catch((error) => {
            if(error.response.data.errors) {
                for (const [key, value] of Object.entries(error.response.data.errors)) {
                    alertStore.showAlert(value[0], 'error', 'mdi-alert-circle')
                    v$.value[key].$touch()
                }
            }else{
                alertStore.showAlert(error.response.data.message, 'error', 'mdi-alert-circle')
            }
        })
}

</script>
