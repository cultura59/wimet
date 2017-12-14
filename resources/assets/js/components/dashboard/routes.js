import VueRouter from 'vue-router';
import dashboardIndex from './Dashboard.vue';
import dashboardMensajes from './Mensajes.vue';
import dashboardMensaje from './Chat.vue';
import dashboardEspacios from './Espacios.vue';
import dashboardPerfil from './Perfil.vue';

const routes = [
    { path: '/', name: 'Dashboard', component: dashboardIndex },
    { path: '/mensajes', name: 'Mensajes', component: dashboardMensajes },
    { path: '/mensaje/:id', name: 'Mensajes', component: dashboardMensaje},
    { path: '/espacios', name: 'Espacios', component: dashboardEspacios},
    { path: '/perfil', name: 'Perfil', component: dashboardPerfil}
];

export const router = new VueRouter({
    routes: routes
});