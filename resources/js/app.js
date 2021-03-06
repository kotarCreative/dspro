/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Fontawesome loader
 */
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSearch, faSkullCrossbones, faPlus, faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faSearch);
library.add(faSkullCrossbones);
library.add(faPlus);
library.add(faExternalLinkAlt);

Vue.component('font-awesome-icon', FontAwesomeIcon);

import Toasted from 'vue-toasted';

const toastOptions = {
    position: 'bottom-right',
    theme: 'bubble',
    duration: 5000,
};
Vue.use(Toasted, toastOptions);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.config.ignoredElements = ['iframe']
const app = new Vue({
    el: '#app',
});
