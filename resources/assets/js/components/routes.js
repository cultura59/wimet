import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexAdmin from './admin/index.vue';
import EspaciosAdmin from './admin/Espacios.vue';
import EventosAdmin from './admin/Eventos.vue';
import ImagenesAdmin from './admin/Imagenes.vue';

const routes = [
    { path: '/admin/', component: IndexAdmin },
    { path: '/admin/espacios', component: EspaciosAdmin },
    { path: '/admin/eventos', component: EventosAdmin },
    { path: '/admin/espacio/:id/imagenes', component: ImagenesAdmin}
];

export const router = new VueRouter({
    routes: routes,
    mode: 'history'
});