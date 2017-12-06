import VueRouter from 'vue-router';
import publicaBasico from './Basico.vue';

const routes = [
    { path: '/', name: 'basico', component: publicaBasico },
];

export const router = new VueRouter({
    routes: routes
});