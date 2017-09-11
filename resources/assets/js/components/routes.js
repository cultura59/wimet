import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexAdmin from './admin/index.vue';

const routes = [
    { path: '/', component: IndexAdmin }
];

export const router = new VueRouter({
    routes: routes
});