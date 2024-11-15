import { createApp } from 'vue';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import router from './router.js';
import App from './AppD.vue';
import { createPinia } from 'pinia';
import i18n from './i18n/index.js';
import 'animate.css';

const pinia = createPinia();

const vuetify = createVuetify({
    components,
    directives,
});

const app = createApp(App);

app.use(vuetify);
app.use(pinia);
app.use(router);
app.use(i18n);

app.mount('#app');
