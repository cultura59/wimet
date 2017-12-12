import VueRouter from 'vue-router';
import publicaBasico from './Basico.vue';
import publicaActividad from './Actividad.vue';
import publicaAmenity from './Amenity.vue';
import publicaDisponibilidad from './Disponibilidad.vue';
import publicaFoto from './Foto.vue';
import publicaDescripcion from './Descripcion.vue';

const routes = [
    { path: '/', name: 'basico', component: publicaBasico },
    { path: '/actividad/:name', name: 'actividad', component: publicaActividad},
    { path: '/amenities', name: 'amenities', component: publicaAmenity},
    { path: '/disponibilidad', name: 'disponibilidad', component: publicaDisponibilidad},
    { path: '/foto', name: 'foto', component: publicaFoto},
    { path: '/descripcion', name: 'descripcion', component: publicaDescripcion}
];

export const router = new VueRouter({
    routes: routes
});