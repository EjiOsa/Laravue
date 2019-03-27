import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポート
import Registration from './admin_pages/UserRegistration'//.vueは省略可能
// import UserDetail from '../../ゴミ箱/UserDetail'
import PhotoSave from './admin_pages/PhotoSave'
import PhotoManage from './admin_pages/PhotoManagement'

import PhotoList from './user_pages/PhotoList'
// import PhotoDetail from '../../ゴミ箱/PhotoDetail'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter);

// ルートパスとコンポーネントの紐付け
const routes = [
    //Adminルート
    {
        path: '/admin/registration',
        name: 'UserRegistration',
        component: Registration
    },
    // {
    //     path: '/admin/UserDetail',
    //     name:'UserDetail',
    //     component: UserDetail
    // },
    {
        path: '/admin/PhotoSave',
        name: 'PhotoSave',
        component: PhotoSave
    },
    {
        path: '/admin/PhotoManagement',
        name: 'PhotoManage',
        component: PhotoManage
    },
    //userルート
    {
        path: '/PhotoList',
        name: 'PhotoList',
        component: PhotoList
    },
    // {
    //     path: '/PhotoDetail',
    //     name: 'PhotoDetail',
    //     component: PhotoDetail
    // }
];

// VueRouterインスタンスを作成する
const routerSetting = new VueRouter({
    mode: 'history',//下のbaseを追加して解決、最初/photo_share/laravue/public/まででダメだった。
    // base:'/photo_share/laravue_test1/public/share_user/',//こっちは直接アクセス用
    base:'/photo_share/laravue_test1/public/',
    routes
});

// VueRouterインスタンスをapp.jsで使用するため、エクスポートする
export default routerSetting