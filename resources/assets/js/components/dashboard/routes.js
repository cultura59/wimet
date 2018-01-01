import VueRouter from 'vue-router';
import dashboardIndex from './Dashboard.vue';
import dashboardMensajes from './Mensajes.vue';
import dashboardMensaje from './Chat.vue';
import dashboardEspacios from './Espacios.vue';
import dashboardFavoritos from './Favorito.vue';
import dashboardPerfil from './Perfil.vue';
import dashboardNuevaPropuesta from './NewPropuesta.vue';

const routes = [
    { path: '/', name: 'Dashboard', component: dashboardIndex },
    { path: '/mensajes', name: 'Mensajes', component: dashboardMensajes },
    { path: '/mensaje/:id', name: 'Mensajes', component: dashboardMensaje},
    { path: '/mensaje/:id/nuevapropuesta', name: 'Nueva propuesta', component: dashboardNuevaPropuesta},
    { path: '/espacios', name: 'Espacios', component: dashboardEspacios},
    { path: '/favoritos', name: 'Favoritos', component: dashboardFavoritos},
    { path: '/perfil', name: 'Perfil', component: dashboardPerfil}
];

export const router = new VueRouter({
    routes: routes
});