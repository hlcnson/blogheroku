
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//  Nạp file bootstrap.js, không phải Bootstrap framework
require('./bootstrap');

// Vue.js
window.Vue = require('vue');

// Nạp thư viện Buefy
import Buefy from 'buefy';
// CSS của Buefy sẽ được nạp trong file CSS của ứng dụng
// import 'buefy/lib/buefy.css';
Vue.use(Buefy);     // Đây là một Vue Component, 
                    // cần phải hoạt động bên trong một Vue Object

// Tạo một đối tượng VueJS có phạm vi bên trong phần tử div có id là app
var app = new Vue({
    el: '#app',
    data: {}
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Không sử dụng Vue component này
// Vue.component('example', require('./components/Example.vue'));

// Không sử dụng đối tượng Vue ở cấp độ ứng dụng này.
// Sẽ tự tạo đối tượng Vue ở từng trang
// const app = new Vue({
//     el: '#app'
// });

