<template>
    <div>
        <h2>Photo Management</h2>
        <v-container fluid grid-list-md>
            <v-layout>
                <v-flex xs6>
                        <manage-user-list
                                :token-data="tokenData"
                                :user-images="userImages"
                                @open-user-photo="openUserPhoto"
                        ></manage-user-list>
                </v-flex>
                <v-flex xs6>
                        <manage-event-list
                                :token-data="tokenData"
                                :event-images="eventImages"
                                @open-event-photo="openEventPhoto"
                        ></manage-event-list>
                </v-flex>
            </v-layout>
        </v-container>
    </div>

</template>

<script>
    import ManageUserList from './manage_conponent/ManageUserList'
    import ManageEventList from './manage_conponent/ManageEventList'

    export default {
        name: "PhotoManagement",
        components:{
            ManageUserList,
            ManageEventList,
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
                DragDropTrigger: false,
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
                for(let i = 0; i < base.length ; i++){
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
            openUserPhoto(id){
                this.userImageGet(id);
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

<style>
    .v-input--selection-controls:not(.v-input--hide-details) .v-input__slot{
        margin-bottom: -12px;
    }
    .v-messages{
        position: unset;
    }
</style>

<!--
==================リファクタリング==================
・スプリット画面にして左右でスクロールを分けたかったけど、今は普通に分割画面に。
・Manage~~Listは一つにまとめられそう。時間をみてまとめる。
・画像の選択方法や選択後の登録方法、あとユーザー画像を開いた状態での追加も実装する。
-->