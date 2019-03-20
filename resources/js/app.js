require('./bootstrap');
import Vue from 'vue'
// window.Vue = require('vue');// import Vue from 'vue'はwindowで入れているから不要？
// window.Vuetify = require('vuetify');

//以下、VeeValidateの導入
import VeeValidate, { Validator } from 'vee-validate';
Vue.use(VeeValidate);
import VeeValidateJaLocale from 'vee-validate/dist/locale/ja'
Validator.localize('ja',VeeValidateJaLocale);

//以下、Vuetifyの導入のためにテストして諦めた。
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'vuetify/src/stylus/app.styl'

//以下、Vuetify導入のためのiconデータ
import '@mdi/font/css/materialdesignicons.css'//mdi
import '@fortawesome/fontawesome-free/css/all.css'//fa
import 'material-design-icons-iconfont/dist/material-design-icons.css'//md


Vue.use(Vuetify,{
    iconfont:'md'||'mdi'||'fa'
});

import router from './router.js'
import UserRoot from './UserRoot'
// import AdminRoot from './AdminRoot.vue'


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('test-select', require('./admin_pages/TestSelect').default);
Vue.component('admin-root', require('./AdminRoot').default);
Vue.component('user-root', require('./UserRoot').default);

const admin_top = new Vue({
    el: '#admin-top',
    router,
    // render:h=>h(AdminRoot)//データの受け渡しで、こいつのせいで渡せなかった。
});

const user_top = new Vue({
    el: '#user-top',
    router,
    render:h=>h(UserRoot)
});