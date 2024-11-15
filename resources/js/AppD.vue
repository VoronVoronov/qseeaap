<template>
    <VLoading :loading="loading" />
    <v-overlay v-model="loading"></v-overlay>
    <VActivate v-if="!loading && !activate && isAuthenticated"
               @activation-success="handleActivationSuccess"
               />
    <VAlert />
    <v-app
        :style="!activate && isAuthenticated ? 'opacity: 0.5' : ''"
    >
        <v-app-bar v-if="isAuthenticated" app dark color="primary">
            <v-toolbar-title>
                <img src="logo.png" alt="logo">
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="toggleDrawer" v-if="smAndDown">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer
            v-if="isAuthenticated && !smAndDown"
            app
            permanent
            dark
            color="primary"
        >
            <v-list
                nav
            >
                <v-list-item
                    v-for="(item, i) in menuItems"
                    :key="i"
                    :value="item"
                    color="white"
                    :active="item.name === router.currentRoute.value.name"
                    @click="handleClick(item.link)"
                >
                    <template v-slot:prepend>
                        <v-icon :icon="item.icon"></v-icon>
                    </template>
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-navigation-drawer
            v-if="isAuthenticated && smAndDown"
            v-model="drawer"
            temporary
        >
            <v-list
                nav
            >
                <v-list-item
                    v-for="(item, i) in menuItems"
                    :key="i"
                    :value="item"
                    color="primary"
                    :active="item.name === router.currentRoute.value.name"
                    @click="handleClick(item.link)"
                >
                    <template v-slot:prepend>
                        <v-icon :icon="item.icon"></v-icon>
                    </template>
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item>
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
import { ref, computed, onMounted, watch } from 'vue';
import { useDisplay } from 'vuetify';
import { useAuthStore } from '@/stores/authStore';
import { axiosGetRequest, axiosRequest } from "@/utils/helper";
import { useRouter } from 'vue-router';
import i18n from '@/i18n';

import VAlert from '@/components/alert/index.vue';
import VLoading from '@/components/loading/index.vue';
import VActivate from '@/components/activate/index.vue';

export default {
    components: {
        VAlert,
        VLoading,
        VActivate
    },
    setup() {
        const { smAndDown } = useDisplay();
        const authStore = useAuthStore();
        const router = useRouter();

        const isAuthenticated = computed(() => authStore.isAuthenticated);
        const loading = ref(false);
        const activate = ref(false);
        const drawer = ref(false);
        const phone = ref('');

        const toggleDrawer = () => {
            drawer.value = !drawer.value;
        };

        const closeDrawer = () => {
            drawer.value = false;
        };

        const navigateTo = (routeName) => {
            router.push({ name: routeName });
        };
        const handleClick = (link) => {
            if (link === 'logout') {
                logout();
            } else {
                navigateTo(link);
            }
        };
        const $t = i18n.global.t;

        const menuItems = [
            { text: $t("navigation.home"), icon: 'mdi-home', link: 'home', name: 'home' },
            { text: $t("navigation.pages"), icon: 'mdi-note', link: 'menu', name: 'menu' },
            { text: $t("navigation.logout"), icon: 'mdi-logout', link: 'logout', name: 'logout' },
        ]


        watch(isAuthenticated, (newVal) => {
            if(newVal){
                if(localStorage.getItem('user')) {
                    const user = JSON.parse(localStorage.getItem('user'));
                    activate.value = user.is_active;
                }
            }
        });

        const getUser = async () => {
            loading.value = true;
            await axiosGetRequest('user/me', (response) => {
                if (response.status && response.status === 401) {
                    localStorage.removeItem('token');
                    router.push({ name: 'login' });
                    authStore.logout();
                    loading.value = false;
                    activate.value = false;
                    return;
                }
                authStore.login();
                loading.value = false;
                activate.value = response.data.is_active
                if(!activate.value){
                    phone.value = response.data.phone;
                }
            });
        };

        onMounted(() => {
            if(localStorage.getItem('token') && !isAuthenticated.value){
                getUser();
            }
        });
        const handleActivationSuccess = () => {
            activate.value = true;
        }

        const logout = () => {
            localStorage.removeItem('token');
            localStorage.removeItem('phone');
            localStorage.removeItem('user');
            router.push({ name: 'login' });
            axiosRequest('user/logout');
            authStore.logout();
        };

        return {
            smAndDown,
            isAuthenticated,
            drawer,
            toggleDrawer,
            closeDrawer,
            navigateTo,
            loading,
            logout,
            menuItems,
            handleClick,
            router,
            activate,
            phone,
            handleActivationSuccess
        };
    },
};
</script>

<style scoped>
.v-toolbar-title {
    flex: 1;
}
</style>
