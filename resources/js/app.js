/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

/**
 * Vuetify Instance
 */
import Vuetify from 'vuetify';
Vue.use(Vuetify);
/**
 * Vue Router Instance
 */

 import VueRouter from 'vue-router';
 Vue.use(VueRouter)

// Defining routes and components
let routes = [
    { path: '/home', component: require('./components/dashboard/main.vue').default},
    { path: '/rubriks', component: require('./components/dashboard/rubrik/index.vue').default},
    { path: '/calendar', component: require('./components/dashboard/calendar/index.vue').default},
    { path: '/tasks', component: require('./components/dashboard/task/index.vue').default},
    { path: '/users', component: require('./components/dashboard/user/index.vue').default},
    { path: '/roles', component: require('./components/dashboard/user/role.vue').default},
    { path: '/stream', component: require('./components/dashboard/stream/index.vue').default},
    { path: '/rubrik/:id', name: 'rubrik', component: require('./components/dashboard/rubrik/detail.vue').default},

    { path: '/rubrikshow', name: 'rubrik', component: require('./components/dashboard/rubrik/detail.vue').default}
]

//Creating the instance of VueRouter and pass the 'routes' option
const router = new VueRouter({
    mode: 'history',
    routes
})

/**
 * Importing Vform for input and auto front-end error input notification
 */
import { Form, HasError, AlertError} from 'vform'
window.Form = Form

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

/**
 * Import Vue-progressbar and make an instance of it
 */

 import ProgressBar from 'vue-progressbar'
 const options = {
    color: '#ac969',
    failedColor: '#cf4100',
    thickness: '5px',
    transition: {
      speed: '1.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
  Vue.use(ProgressBar,options)

  /**
   * Import SweetAlert and make an instance of it
   */

   import swal from 'sweetalert2'
   const Toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  window.Swal = swal
  window.Toast = Toast

/**
 * Import and make an instance of vue-select
 */
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

/**
 * Import and make an instance of vue2 Date Picker
 */

 import DatePicker from 'vue2-datepicker';
 import 'vue2-datepicker/locale/id'
 Vue.use(DatePicker);

 /**
  * Import Moment for date display formatting
  */
 import moment from 'moment'
 Vue.filter('formatDate', function(date) {
   if (date) {
     return moment(date).format('dddd, DD MMM YYYY')
   }
 })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('rubrik-show', require('./components/dashboard/rubrik/detail.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify
});
