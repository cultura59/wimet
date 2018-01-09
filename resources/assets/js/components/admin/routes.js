import VueRouter from 'vue-router';
import IndexAdmin from './index.vue';
import UsuariosAdmin from './Usuarios.vue';
import EspaciosAdmin from './Espacios.vue';
import EventosAdmin from './Eventos.vue';
import ImagenesAdmin from './Imagenes.vue';
import MensajesAdmin from './Mensajes.vue';

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