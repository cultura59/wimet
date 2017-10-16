import VueRouter from 'vue-router';
import IndexAdmin from './admin/index.vue';
import UsuariosAdmin from './admin/Usuarios.vue';
import EspaciosAdmin from './admin/Espacios.vue';
import EventosAdmin from './admin/Eventos.vue';
import ImagenesAdmin from './admin/Imagenes.vue';
import MensajesAdmin from './admin/Mensajes.vue';

const routes = [
    { path: '/', component: IndexAdmin },
    { path: '/usuarios', component: UsuariosAdmin },
    { path: '/espacios', component: EspaciosAdmin },
    { path: '/eventos', component: EventosAdmin },
    { path: '/espacio/:id/imagenes', component: ImagenesAdmin},
    { path: '/evento/:id/mensajes', component: MensajesAdmin}
];

export const router = new VueRouter({
    routes: routes
});