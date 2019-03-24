<template>
    <div>
        <h2>Photo Management</h2>
        <v-container fluid grid-list-md>
            <v-layout row wrap>
                <v-flex d-flex xs5>
                        <manage-user-list
                                :token-data="tokenData"
                                :user-images="userImages"
                                @open-user-photo="openUserPhoto"
                        ></manage-user-list>
                </v-flex>
                <v-flex d-flex xs7>
                        <manage-event-list
                                :token-data="tokenData"
                                :event-images="eventImages"
                                @open-event-photo="openEventPhoto"
                        ></manage-event-list>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
            <!--<ul>-->
            <!--<thumbnail-photo-->
                    <!--v-for="image in userImages"-->
                    <!--:key="image.name"-->
                    <!--:image="image"-->
                    <!--v-show="!showFolder"-->
            <!--&gt;</thumbnail-photo>-->
        <!--</ul>-->
        <!--<ul>-->
            <!--<photo-folder-->
                    <!--v-for="user in users"-->
                    <!--:key="user.id"-->
                    <!--:folderData="user"-->
                    <!--v-show="showFolder"-->
                    <!--@userImage = "userImage"-->
            <!--&gt;</photo-folder>-->
        <!--</ul>-->
        <!--<div>-->
            <!--<photo-folder-base-->
                    <!--:token-data="tokenData"-->
            <!--&gt;</photo-folder-base>-->
        <!--</div>-->
        <!--<div>-->
            <!--<event-folder-base-->
                    <!--:token-data="tokenData"-->
            <!--&gt;</event-folder-base>-->
        <!--</div>-->
        <!--<ul>-->
            <!--<thumbnail-photo-->
                    <!--v-for="image in images"-->
                    <!--:key="image.name"-->
                    <!--:image="image"-->
            <!--&gt;</thumbnail-photo>-->
        <!--</ul>-->
</template>

<script>
    import ManageUserList from './folder_conponent/ManageUserList'
    import ManageEventList from './folder_conponent/ManageEventList'
    // import PhotoFolder from './folder_conponent/Folder'
    // import ThumbnailPhoto from './save_component/ThumbnailPhoto'

    // const ApiUrl = 'http://localhost/photo_share/laravue_test1/public/api/items';
    // const ApiAxios = require('axios').create({
    //     baseURL: ApiUrl,
    // });
    // ApiAxios.defaults.headers['Accept'] = 'application/json';

    // const PhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photos';
    // const PhotoAxios = require('axios').create({
    //     baseURL: PhotoUrl,
    // });

    export default {
        name: "PhotoManagement",
        components:{
            ManageUserList,
            ManageEventList,
            // Folder,
            // ThumbnailPhoto,
        },
        props:{
            tokenData: {
                type: String,
                required: true
            }
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data () {
            return {
                eventImages:[],
                userImages: [],
                // images: [],
                // users:[],
                // showFolder: true,
            };
        },
        async mounted () {
            // PhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            // await PhotoAxios.get()
            //     .then(response => (this.images = response.data));
            // this.remakeData(this.images, this.images);

            // ApiAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            // await ApiAxios.get()
            //     .then(response => (this.users = response.data));
        },
        methods: {
            remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
                for(var i = 0; i < base.length ; i++){
                    base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
                }
                data = base;
            },

            //ユーザーの写真表示
            async userImageGet(user_id){
                const UserPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation/'+user_id;
                const UserPhotoAxios = require('axios').create({
                    baseURL: UserPhotoUrl,
                });
                UserPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await UserPhotoAxios.get()
                    .then(response => (this.userImages = response.data));
                this.remakeData(this.userImages, this.userImages);
            },
            openUserPhoto(user){
                this.userImageGet(user.id);
            },

            //イベントの写真表示
            async eventImageGet(event_id){
                const EventPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/event_photo_relation/'+event_id;
                const EventPhotoAxios = require('axios').create({
                    baseURL: EventPhotoUrl,
                });
                EventPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await EventPhotoAxios.get()
                    .then(response => (this.eventImages = response.data));
                this.remakeData(this.eventImages, this.eventImages);
            },
            openEventPhoto(event){
                this.eventImageGet(event.id);
            },
        },
    }
</script>

<style scoped>
    /*.split-box{*/
        /*display: table;*/
        /*position: absolute;*/
        /*width: 50%;*/
        /*height: 100%;*/
    /*}*/

    /*.left-box {*/
        /*!*width:50%;*!*/
        /*left:0;*/
        /*overflow-y:scroll;*/
    /*}*/

    /*.right-box {*/
        /*!*width:50%;*!*/
        /*right:0;*/
        /*!*overflow-y:scroll;*!*/
    /*}*/
</style>

<!--
==================リファクタリング==================
・スプリット画面にして左右でスクロールを分けたかったけど、今は普通に分割画面に。
・Manage~~Listは一つにまとめられそう。時間をみてまとめる。
-->