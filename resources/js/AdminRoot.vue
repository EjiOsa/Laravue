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
                    dark
                    disable-resize-watcher
                    width="220"
            >
                <v-list dense>
                    <v-list-tile to="/admin/home">
                        <v-list-tile-action>
                            <v-icon>home</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                Home
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <v-list-tile to="/admin/Registration">
                        <v-list-tile-action>
                            <v-icon>supervised_user_circle</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                User Registration
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

                    <v-list-tile to="/admin/PhotoSave">
                        <v-list-tile-action>
                            <v-icon>cloud_download</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                Photo Save
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <v-list-tile to="/admin/PhotoManagement">
                        <v-list-tile-action>
                            <v-icon>description</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                Photo Management
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

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

                    <!--使う方法があれば使用する。-->
                    <!--<v-list-tile @click.stop="right = !right">-->
                        <!--<v-list-tile-action>-->
                            <!--<v-icon>exit_to_app</v-icon>-->
                        <!--</v-list-tile-action>-->
                        <!--<v-list-tile-content>-->
                            <!--<v-list-tile-title>-->
                                <!--Open Drawer-->
                            <!--</v-list-tile-title>-->
                        <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->

                </v-list>
            </v-navigation-drawer>
            <!--======ツールバー======-->
            <v-toolbar
                    color="blue-grey"
                    dark
                    fixed
                    app
                    clipped-right
            >
                <v-toolbar-side-icon @click.stop="drawerLeft = !drawerLeft"></v-toolbar-side-icon>
                <!--<v-toolbar-title to="/admin/home">Admin Home</v-toolbar-title>-->
                <v-btn to="/admin/home" flat large>Admin Home</v-btn>
                <v-spacer></v-spacer>
                <v-toolbar-side-icon @click.stop="drawerRight = !drawerRight"></v-toolbar-side-icon>
            </v-toolbar>
            <v-navigation-drawer
                    fixed
                    v-model="drawerLeft"
                    app
                    disable-resize-watcher
            >
                <v-list dense>
                    <v-list-tile @click.stop="left = !left">
                        <v-list-tile-action>
                            <v-icon>exit_to_app</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Open Temporary Drawer</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-navigation-drawer>
            <v-navigation-drawer
                    temporary
                    v-model="left"
                    fixed
            ></v-navigation-drawer>
            <!--======ルートページ======-->
            <v-content>
                <v-container fluid>
                    <v-layout justify-center align-center>
                        <!--<v-flex shrink>-->
                            <!--<v-tooltip right>-->
                                <!--<v-btn-->
                                        <!--icon-->
                                        <!--large-->
                                        <!--:href="source"-->
                                        <!--target="_blank"-->
                                        <!--slot="activator"-->
                                <!--&gt;-->
                                    <!--<v-icon large>code</v-icon>-->
                                <!--</v-btn>-->
                                <!--<span>-->
                            <div class="container">
                                <router-view :token-data="tokenData"/>
                            </div>
                                <!--</span>-->
                            <!--</v-tooltip>-->
                        <!--</v-flex>-->
                    </v-layout>
                </v-container>
            </v-content>

            <!--使い道を検討中-->
            <!--<v-navigation-drawer-->
                    <!--right-->
                    <!--temporary-->
                    <!--v-model="right"-->
                    <!--fixed-->
            <!--&gt;</v-navigation-drawer>-->

            <v-footer color="blue-grey" class="white--text">
                <span>Vuetify</span>
                <v-spacer></v-spacer>
                <span>&copy; 2019  </span>
            </v-footer>
        </v-app>
    </div>
    <!--<div>-->
        <!--<main>-->
            <!--<div>-->
                <!--<a href="/photo_share/laravue_test1/public/admin/logout" onclick="event.preventDefault();-->
        <!--document.getElementById('logout-form').submit();">-->
                    <!--<i class="fa fa-sign-out"></i>-->
                    <!--Logout-->
                <!--</a>-->
                <!--<form id="logout-form" action="/logout" method="POST" style="display: none;">-->
                    <!--<input type="hidden" name="_token" :value="csrf_token">-->
                <!--</form>-->
            <!--</div>-->
            <!--<div class="base">-->
                <!--<router-link  to="/admin/registration" class="btn btn-outline-secondary">-->
                    <!--<a>-->
                        <!--Registration-->
                    <!--</a>-->
                <!--</router-link>-->
                <!--<router-link  to="/admin/UserDetail" class="btn btn-outline-secondary">-->
                    <!--<a>-->
                        <!--UserDetail-->
                    <!--</a>-->
                <!--</router-link>-->
                <!--<router-link  to="/admin/PhotoSave" class="btn btn-outline-secondary">-->
                    <!--<a>-->
                        <!--PhotoSave-->
                    <!--</a>-->
                <!--</router-link>-->
                <!--<router-link  to="/admin/PhotoManagement" class="btn btn-outline-secondary">-->
                    <!--<a>-->
                        <!--PhotoManage-->
                    <!--</a>-->
                <!--</router-link>-->
            <!--</div>-->
            <!--<div class="container">-->
                <!--<router-view :token-data="tokenData"/>-->
            <!--</div>-->
        <!--</main>-->
    <!--</div>-->
</template>

<script>
    // let csrf_token = $('meta[name="csrf-token"]').attr('content');//これ使ってない。vueでログアウトの時に書いた文のようだけど、コピペで忘れた。

    export default {
        name: "AdminRoot",
        props:{
            tokenData: {
                type: String,
                required: true,
                // source: String
            }
        },
        data(){
            return {
                show: true,
                // token: csrf_token,
                drawerRight: true,
                drawerLeft: false,
                // right: null,
                left: null,
            }
        },
        methods:{
            logout(){
                if (confirm('ログアウトしますか？')) {
                    event.preventDefault();
                    document.getElementById('admin-logout-form').submit();//これでadmin_topのを呼んでる。
                }
            }
        },
    }
</script>

<style scoped>

</style>
<!--
==================リファクタリング========================
・ログイン後とフォントと色を合わせる。色は合わせたけど、フォントはどこだろ？


-->