import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexAdmin from './admin/index.vue';
import EspaciosAdmin from './admin/Espacios.vue';
import EventosAdmin from './admin/Eventos.vue';

const routes = [
    { path: '/', component: IndexAdmin },
    { path: '/espacios', component: EspaciosAdmin },
    { path: '/eventos', component: EventosAdmin }
];

export const router = new VueRouter({
    routes: routes
});