
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//  Nạp file bootstrap.js, không phải Bootstrap framework
require('./bootstrap');

// Nạp Vue.js Framework
window.Vue = require('vue');
// Nạp thư viện slug.js. Đây là thư viện để tạo slug cho chuỗi ký tự
window.Slug = require('slug');
// Thiết lập chuẩn chuyển đổi chuỗi thành slug chứa toàn ký tự thường
Slug.defaults.mode = 'rfc3986';

// Nạp thư viện Buefy
import Buefy from 'buefy';
// CSS của Buefy sẽ được nạp trong file CSS của ứng dụng
// import 'buefy/lib/buefy.css';
Vue.use(Buefy);     // Đây là một Vue Component, 
                    // cần phải hoạt động bên trong một Vue Object

// Tạo một đối tượng VueJS có phạm vi bên trong phần tử div có id là app
// var app = new Vue({
//     el: '#app',
//     data: {}
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Sử dụng Vue component, lệnh này phải sau lệnh nạp Vue Framework.
// Đối số 1: Tên của Vue component, slugWidget (đặt theo cú pháp camel case,
// nhưng trong mã HTML tại nơi sử dụng component phải tham chiếu tên bằng
// cú pháp ngăn cách các từ trong tên bằng dấu gạch ngang -).
// Đối số 2: Nơi tìm component (đặt trong thư mục /resources/assets/js/components/slugWidget.vue).
Vue.component('slugWidget', require('./components/slugWidget.vue'));

// Không sử dụng đối tượng Vue ở cấp độ ứng dụng này.
// Sẽ tự tạo đối tượng Vue ở từng trang
// const app = new Vue({
//     el: '#app'
// });

// Code để hiển thị menu, sử dụng JQuery
// $(document).ready(function(){
//     // Khi mouse di chuyển trên nút menu, sự kiện hover xảy ra khi mouse đi
//     // vào và đi ra khỏi nút lệnh
//     // $('button.dropdown').hover(function(e){
//     //     // Thêm/xóa class tên is-open cho nút menu
//     //     $(this).toggleClass('is-open');
//     // });

//     // $('.navbar-burger').click(function(e){
//     //     var target = $(this).data('target');
//     //     $(this).toggleClass('is-active');
//     //     $('#' + target).toggleClass('is-active');
//     // });
// });

document.addEventListener('DOMContentLoaded', function () {
    document.getElementsByClassName("navbar-burger")[0].addEventListener("click", function() {
        var target = this.getAttribute('data-target');
        document.getElementById(target).classList.toggle("is-active");
        this.classList.toggle("is-active");
    });
});

// Nạp file manage.js
require('./manage');