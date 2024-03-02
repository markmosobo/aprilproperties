import './bootstrap';
// import "url(../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css)";
// import "url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,700,700i&amp;display=swap)";
// import "url(https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,400;1,700&amp;display=swap)";
// @charset "UTF-8";


//dashboard template
// imports for css
import "@/assets/vendor/bootstrap/css/bootstrap.min.css";
import "@/assets/vendor/bootstrap-icons/bootstrap-icons.css";
import "@/assets/vendor/boxicons/css/boxicons.min.css";
import "@/assets/vendor/quill/quill.snow.css";
import "@/assets/vendor/quill/quill.bubble.css";
import "@/assets/vendor/remixicon/remixicon.css";
import "@/assets/vendor/simple-datatables/style.css";
import "@/assets/css/style.css";

// imports js
import "@/assets/vendor/apexcharts/apexcharts.min.js";
import "@/assets/vendor/bootstrap/js/bootstrap.bundle.min.js";
import "@/assets/vendor/chart.js/chart.umd.js";
import "@/assets/vendor/echarts/echarts.min.js";
import "@/assets/vendor/quill/quill.min.js";
import "@/assets/vendor/simple-datatables/simple-datatables.js";
import "@/assets/vendor/tinymce/tinymce.min.js";
import "@/assets/vendor/php-email-form/validate.js";
// main js file
import "@/assets/js/main.js";


import {createApp} from 'vue/dist/vue.esm-bundler.js'

import AppComponent from './components/App.vue'
import router from './router/index'



const app=createApp({
    components: {
        AppComponent
    }
})

app.use(router)
app.mount('#app')

// createApp(App).use(router)
// createApp(App).mount("#app")
