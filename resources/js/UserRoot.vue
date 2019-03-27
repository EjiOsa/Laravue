<template>
    <div id="app">
        <v-app id="inspire">
            <!--======右案内======-->
            <v-navigation-drawer
                    fixed
                    v-model="drawerRight"
                    right
                    clipped
                    app
                    disable-resize-watcher
                    width="220"
            >
                <v-list dense>
                    <v-list-tile to="/home">
                        <v-list-tile-action>
                            <v-icon>home</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                Home
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <v-list-tile to="/PhotoList">
                        <v-list-tile-action>
                            <v-icon>supervised_user_circle</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                PhotoList
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <!--<v-list-tile to="/admin/UserDetail">-->
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>find_in_page</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <!--<v-list-tile-content>-->
                    <!--<v-list-tile-title>-->
                    <!--UserDetail-->
                    <!--</v-list-tile-title>-->
                    <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->

                    <!--<v-list-tile to="/admin/PhotoSave">-->
                        <!--<v-list-tile-action>-->
                            <!--<v-icon>cloud_download</v-icon>-->
                        <!--</v-list-tile-action>-->
                        <!--<v-list-tile-content>-->
                            <!--<v-list-tile-title>-->
                                <!--Photo Save-->
                            <!--</v-list-tile-title>-->
                        <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->

                    <!--<v-list-tile to="/admin/PhotoManagement">-->
                        <!--<v-list-tile-action>-->
                            <!--<v-icon>description</v-icon>-->
                        <!--</v-list-tile-action>-->
                        <!--<v-list-tile-content>-->
                            <!--<v-list-tile-title>-->
                                <!--Photo Management-->
                            <!--</v-list-tile-title>-->
                        <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->

                    <v-list-tile @click="logout">
                        <!--<a href="/photo_share/laravue_test1/public/admin/logout"-->
                        <!--onclick="event.preventDefault();-->
                        <!--document.getElementById('logout-form').submit();">-->
                        <!--</a>-->
                        <v-list-tile-action>
                            <v-icon>fas fa-sign-out-alt</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                Logout
                            </v-list-tile-title>
                        </v-list-tile-content>
                        <!--<form id="logout-form" action="/logout" method="POST">-->
                        <!--<input type="hidden" name="_token" :value="csrf_token">-->
                        <!--</form>-->
                    </v-list-tile>

                </v-list>
            </v-navigation-drawer>
            <!--======ツールバー======-->
            <v-toolbar
                    color="grey lighten-2"
                    fixed
                    app
                    clipped-right
            >
                <!--<v-toolbar-side-icon @click.stop="drawerLeft = !drawerLeft"></v-toolbar-side-icon>-->
                <!--<v-toolbar-title to="/admin/home">Admin Home</v-toolbar-title>-->
                <v-btn to="/home" flat large>User Home</v-btn>
                <v-spacer></v-spacer>
                <v-toolbar-side-icon @click.stop="drawerRight = !drawerRight"></v-toolbar-side-icon>
            </v-toolbar>
            <!--<v-navigation-drawer-->
                    <!--fixed-->
                    <!--v-model="drawerLeft"-->
                    <!--app-->
                    <!--disable-resize-watcher-->
            <!--&gt;-->
                <!--<v-list dense>-->
                    <!--<v-list-tile @click.stop="left = !left">-->
                        <!--<v-list-tile-action>-->
                            <!--<v-icon>exit_to_app</v-icon>-->
                        <!--</v-list-tile-action>-->
                        <!--<v-list-tile-content>-->
                            <!--<v-list-tile-title>Open Temporary Drawer</v-list-tile-title>-->
                        <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->
                <!--</v-list>-->
            <!--</v-navigation-drawer>-->
            <!--<v-navigation-drawer-->
                    <!--temporary-->
                    <!--v-model="left"-->
                    <!--fixed-->
            <!--&gt;</v-navigation-drawer>-->
            <!--======ルートページ======-->
            <v-content>
                <v-container fluid>
                    <v-layout justify-center align-center>
                        <div class="container">
                            <router-view
                                    :token-data="tokenData"
                                    :user-id="userId"
                            />
                        </div>
                    </v-layout>
                </v-container>
            </v-content>

            <!--=======フッター=======-->
            <v-footer color="grey lighten-2" class="black--text">
                <span>Vuetify</span>
                <v-spacer></v-spacer>
                <span>&copy; 2019  </span>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
    // let user_csrf_token = $('meta[name="user-csrf-token"]').attr('content');

    export default {
        name: "UserRoot",
        props:{
            tokenData: {
                type: String,
                required: true,
                // source: String
            },
            userId:{
                type: String
            }
        },
        data(){
            return {
                show: true,
                drawerRight: true,
                // token: user_csrf_token,
                // drawerLeft: false,
                // right: null,
                // left: null,
            }
        },
        methods:{
            logout(){
                if (confirm('ログアウトしますか？')) {
                    event.preventDefault();
                    document.getElementById('user-logout-form').submit();
                }
            }
        },
    }
</script>

<style scoped>

</style>
<!--<template>-->
    <!--<div>-->
        <!--<main>-->
            <!--<div class="base">-->
                <!--<router-link  to="/PhotoList" class="btn btn-info">-->
                    <!--<a>-->
                        <!--PhotoList-->
                    <!--</a>-->
                <!--</router-link>-->
                <!--<router-link  to="/PhotoDetail" class="btn btn-info">-->
                    <!--<a>-->
                        <!--PhotoDetail-->
                    <!--</a>-->
                <!--</router-link>-->
            <!--</div>-->
            <!--<div class="container">-->
                <!--<router-view />-->
            <!--</div>-->
        <!--</main>-->
    <!--</div>-->
<!--</template>-->

<!--<script>-->
    <!--export default {-->
        <!--name: "user_root",-->
        <!--data(){-->
            <!--return {-->
                <!--show: true-->
            <!--}-->
        <!--},-->
    <!--}-->
<!--</script>-->

<!--<style scoped>-->

<!--</style>-->