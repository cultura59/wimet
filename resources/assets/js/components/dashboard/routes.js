import VueRouter from 'vue-router';
import dashboardIndex from './Dashboard.vue';
import dashboardMensajes from './Mensajes.vue';
import dashboardMensaje from './Chat.vue';
import dashboardEspacios from './Espacios.vue';
import dashboardFavoritos from './Favorito.vue';
import dashboardPerfil from './Perfil.vue';
import dashboardSolicitudDatos from './SolicitudDatos.vue';
import dashboardNuevaPropuesta from './NuevaPropuesta.vue';

const routes = [
    { path: '/', name: 'Dashboard', component: dashboardIndex },
    { path: '/mensajes', name: 'Mensajes', component: dashboardMensajes },
    { path: '/mensaje/:id', name: 'Mensaje', component: dashboardMensaje},
    { path: '/mensaje/:id/solicitud', name: 'solicitud', component: dashboardSolicitudDatos},
    { path: '/mensaje/:id/nuevapropuesta', name: 'nueva-propuesta', component: dashboardNuevaPropuesta},
    { path: '/espacios', name: 'Espacios', component: dashboardEspacios},
    { path: '/favoritos', name: 'Favoritos', component: dashboardFavoritos},
    { path: '/perfil', name: 'Perfil', component: dashboardPerfil}
];

export const router = new VueRouter({
    routes: routes
});