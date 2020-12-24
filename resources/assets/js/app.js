/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import TasksIndex from './components/tasks/TasksIndex.vue';
import TaskCreate from './components/tasks/TaskCreate.vue';
import TaskEdit from './components/tasks/TaskEdit.vue';

const routes = [
    {
        path: '/',
        components: {
            tasksIndex: TasksIndex
        }
    },
    {path: '/task/create', component: TaskCreate, name: 'createTask'},
    {path: '/task/edit/:id', component: TaskEdit, name: 'editTask'},
]

const router = new VueRouter({
    mode: 'history',
    hashbang: false,
    linkActiveClass: 'active',
    routes
})
router.mode = 'html5'

const app = new Vue({router}).$mount('#app')
