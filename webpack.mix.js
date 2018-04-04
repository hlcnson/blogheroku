// Nạp công cụ Laravel Mix, công cụ để tự động hóa các tác vụ như biên dịch
// các file js, scss...
let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// Khi chạy lệnh npm run dev trong thư mục gốc của dự án:
// File resources/assets/js/app.js sẽ được biên dịch thành file public/js/app.js, 
// file resources/assets/sass/app.scss sẽ được biên dịch thành file public/css/app.css.
// '.js' và '.sass' là các phương thức của Mix.
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
