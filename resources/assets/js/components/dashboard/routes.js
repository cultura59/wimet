import VueRouter from 'vue-router';
import dashboardMensajes from './Mensajes.vue';
import dashboardMensaje from './Chat.vue';
import dashboardEspacios from './Espacios.vue';
import dashboardPerfil from './Perfil.vue';

const routes = [
    { path: '/mensajes', name: 'Mensajes', component: dashboardMensajes },
    { path: '/mensaje/:id', name: 'Mensaje', component: dashboardMensaje},
    { path: '/espacios', name: 'Espacios', component: dashboardEspacios},
    { path: '/perfil', name: 'Perfil', component: dashboardPerfil}
];

export const router = new VueRouter({
    routes: routes
});