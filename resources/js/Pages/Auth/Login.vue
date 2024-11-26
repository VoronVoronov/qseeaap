<template>
    <v-row
        align="center"
        no-gutters
        justify="center"
        style="height: 75vh;"
    >
        <v-card width="450px">
            <v-card-title>{{ $t('auth.login') }}</v-card-title>
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

                    <div class="password-container">
                        <v-text-field
                            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                            :type="visible ? 'text' : 'password'"
                            v-model="state.password"
                            :error-messages="v$.password.$errors.map(e => e.$message)"
                            :label="$t('auth.form.password')"
                            required
                            @blur="v$.password.$touch"
                            @input="v$.password.$touch"
                            @click:append-inner="visible = !visible"
                        ></v-text-field>

                        <router-link
                            class="forgot-password-link"
                            :to="{ name: 'restorePassword' }"
                            rel="noopener noreferrer"
                        >
                            {{ $t('auth.form.forgot_password') }}
                        </router-link>
                    </div>

                    <v-checkbox
                        v-model="state.remember"
                        :label="$t('auth.form.remember_me')"
                    />


                    <v-btn
                        class="me-4"
                        @click="login()"
                    >
                        {{ $t('auth.form.login_btn') }}
                    </v-btn>
                    <v-btn @click="gotoRegister()">
                        {{ $t('auth.form.register_btn') }}
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
import { useAuthStore } from '../../stores/authStore'
import { Required, mLength } from '../../utils/validator'

const router = useRouter()
const alertStore = useAlertStore()
const authStore = useAuthStore()

const visible = ref(false)

const initialState = {
    phone: '',
    password: '',
    remember: false,
}

const state = reactive({
    ...initialState,
})

const rules = {
    phone: {
        Required
    },
    password: {
        Required,
        mLength: mLength(6)
    },
}

const v$ = useVuelidate(rules, state)

function clear () {
    v$.value.$reset()

    for (const [key, value] of Object.entries(initialState)) {
        state[key] = value
    }
}

function gotoRegister () {
    clear()
    router.push({ name: 'register' })
}

function login(){
    if (v$.value.$invalid) {
        v$.value.$touch()
        return
    }

    axios.post(`${url_api}user/login`, state)
        .then((response) => {
            localStorage.setItem('token', response.data.token)
            localStorage.setItem('phone', state.phone)
            localStorage.setItem('user', JSON.stringify(response.data.user))
            authStore.login()
            router.push({ name: 'home' })
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
<style scoped>
.password-container {
    position: relative;
    display: flex;
    flex-direction: column;
}

.forgot-password-link {
    align-self: flex-end;
    margin-top: 4px;
    font-size: 0.875rem;
    color: #1976D2;
    text-decoration: none;
}

.forgot-password-link:hover {
    text-decoration: underline;
}
</style>
