<template>
    <v-app style="background: linear-gradient(180deg, #242424 0%, #2E2BBE 100%); color: #ffffff;">
        <v-app-bar v-if="isAuthenticated" app :style="{ backgroundColor: 'rgba(36, 36, 36, 0.646)', backdropFilter: 'blur(15px)', color: '#ffffff'}" dark>
            <v-toolbar-title>Моя Шапка</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="drawer = !drawer" class="d-md-none">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer v-if="isAuthenticated && !smAndDown" app permanent :style="{ backgroundColor: 'rgba(36, 36, 36, 0.646)', backdropFilter: 'blur(15px)', color: '#ffffff'}" dark>
            <v-list>
                <v-list-item>Пункт меню 1</v-list-item>
                <v-list-item>Пункт меню 2</v-list-item>
                <v-list-item>Пункт меню 3</v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-navigation-drawer v-if="isAuthenticated" v-model="drawer" temporary class="d-md-none">
            <v-list>
                <v-list-item @click="drawer = false">Пункт меню 1</v-list-item>
                <v-list-item @click="drawer = false">Пункт меню 2</v-list-item>
                <v-list-item @click="drawer = false">Пункт меню 3</v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <v-container fluid>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { useDisplay } from 'vuetify';
import { useAuthStore } from '@/stores/authStore';
import { useTheme } from 'vuetify'
import VAlert from '@/components/alert/index.vue';

export default {
    components: {
        VAlert,
    },
    setup() {
        const { smAndDown } = useDisplay();
        const authStore = useAuthStore();
        // useTheme().global.name.value = useTheme().global.current.value.dark ? 'light' : 'dark'
        return {
            smAndDown,
            isAuthenticated: authStore.isAuthenticated,
        };
    },
    data() {
        return {
            drawer: false,
        };
    },
};
</script>

<style scoped>
.v-toolbar-title {
    flex: 1;
}
</style>
