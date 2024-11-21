import { createWebHistory, createRouter } from 'vue-router';
import { useAuthStore } from './stores/authStore';
import HomeView from './Pages/HomeView.vue';
import AboutView from './Pages/AboutView.vue';
import Register from "./Pages/Auth/Register.vue";
import Login from "./Pages/Auth/Login.vue";
import Menu from "./Pages/Menu/MenuView.vue";
import MenuEdit from "./Pages/Menu/MenuEdit.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,
        meta: {
            isAuth: true
        }
    },
    {
        path: '/about',
        name: 'about',
        component: AboutView,
        meta: {
            isAuth: true
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            isAuth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            isAuth: false
        }
    },
    {
        path: '/menu',
        name: 'menu',
        component: Menu,
        meta: {
            isAuth: true
        }
    },
    {
        path: '/menu/:id',
        name: 'menu.edit',
        component: MenuEdit,
        meta: {
            isAuth: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.isAuth && !localStorage.getItem('token')) {
        authStore.logout();
        next('/login');
    } else {
        next();
    }
});

export default router;
