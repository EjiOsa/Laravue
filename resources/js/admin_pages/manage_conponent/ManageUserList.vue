<template>
    <v-container
            fluid
            grid-list-md
    >
        <h2 v-show="showList">User List</h2>
        <h2 v-show="!showList">{{listTitle}}'s Photo List</h2>
        <v-layout row wrap>
            <v-flex
                    v-show="showList"
                    v-for="user in users"
                    :key="user.id"
                    xs12
                    sm6
                    md4
                    lg3
            >
                <v-card
                        @dblclick=openUserPhoto(user)
                        @drop.prevent="photoDrop(user)"
                >
                    <!--<span class="headline black&#45;&#45;text" v-text="user.first_name"></span>-->
                    <v-card-title><h5>{{user.first_name}}</h5></v-card-title>
                    <v-divider></v-divider>
                    <v-list dense>
                        <v-list-tile>
                            <v-list-tile-content>Photos:</v-list-tile-content>
                            <v-list-tile-content class="align-end">{{user.photo_count}}</v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex
                    v-for="image in userImages"
                    :key="image.id"
                    align-self-center
                    xs12
                    sm8
                    md6
                    lg4
            >
                <!--align-self-centerで上下の中央揃え-->
                <v-card color="blue-grey lighten-5">
                    <v-img :src="image.photo"></v-img>
                    <v-card-actions class="px-1 py-0">
                        <v-checkbox
                                v-model="selectedDeletePhotoId"
                                :value=image
                                class="pa-0 ma-1"
                        >
                        </v-checkbox>
                        <v-spacer></v-spacer>
                        <!--<v-btn icon @click="photoDetailOpen(image)">-->
                        <!--<v-icon>open_in_browser</v-icon>-->
                        <!--</v-btn>-->
                        <v-btn
                                icon
                                @click="userPhotoDelete(image)"
                                small
                        >
                            <v-icon>delete</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout justify-end>
            <v-btn
                    color="grey lighten-4"
                    @click="deletePhotoAllCheck"
                    v-show="!showList"
            >All Check</v-btn>
            <v-btn
                    color="grey lighten-4"
                    @click="deletePhotoCheckClear"
                    v-show="!showList"
            >Check Clear</v-btn>
            <v-btn
                    color="blue-grey lighten-1"
                    @click="checkPhotoDelete"
                    v-show="!showList"
            >Check Photo Delete</v-btn>
        </v-layout>
        <v-layout justify-end>
            <v-btn
                    color="blue-grey lighten-4"
                    @click="backList"
                    v-show="!showList"
            >Back to User List</v-btn>
        </v-layout>
    </v-container>
</template>

<script>
    const PhotoUserUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation';
    const PhotoUserAxios = require('axios').create({
        baseURL: PhotoUserUrl,
    });
    const UsersUrl = 'http://localhost/photo_share/laravue_test1/public/api/users';
    const UserAxios = require('axios').create({
        baseURL: UsersUrl,
    });
    UserAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "ManageUserList",
        components:{
        },
        props:{
            tokenData: {
                type: String,
                required: true
            },
            userImages:{
                type: Array,
            },
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data () {
            return {
                users:[],
                showList: true,
                listTitle:'',
                selectUserId:'',
                selectedDeletePhotoId:[],
            };
        },
        async mounted () {
            UserAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UserAxios.get()
                .then(response => (this.users = response.data));
        },
        methods: {
            //リストの再描画
            async userListUpload(){
                UserAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await UserAxios.get()
                    .then(response => (this.users = response.data));
            },
            // //dataTransferは文字列のみらしいので、ここで文字列をリストに変換。でも、配列はFormDataで送れないので今回は使用せず。
            // makeUserIdList(photoStrId){
            //     return  photoStrId.replace(/,$/,'').split(/,/);
            // },
            //ドロップ
            async photoDrop(user){
                let userId = user.id;
                let photoId = event.dataTransfer.getData("text");
                let formData = new FormData();

                if (!photoId) {
                    //写真のチェックがないままドロップした時
                    alert('写真が選択されていません。');
                } else {
                    formData.append('user_id', userId);
                    formData.append('move_id_str', photoId);//FormDataには配列は渡せないのでそのまま文字列で。

                    PhotoUserAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                    await PhotoUserAxios.post('', formData)
                        .then(
                            alert('photo relation ok'),
                        )
                        .catch(function (err) {
                            alert(err);
                        });
                    this.userListUpload();
                }
            },
            //ユーザーの画像表示
            openUserPhoto(user){
                this.listTitle = user.first_name;
                this.selectUserId = user.id;
                this.showList =false;
                this.$emit('open-user-photo', this.selectUserId);
            },
            //リストに戻る
            backList(){
                this.showList = true;
                this.$parent.userImages = [];
                this.selectedDeletePhotoId = [];
            },
            //ユーザーの写真削除
            async userPhotoDelete(image){
                PhotoUserAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                await PhotoUserAxios.put(PhotoUserUrl+'/'+this.selectUserId, image)
                    .then(
                        alert('photo delete ok'),
                    )
                    .catch(function (err) {
                        alert(err);
                    });
                this.$parent.userImages = [];
                this.$emit('open-user-photo', this.selectUserId);
                this.userListUpload();
            },
            //ユーザーの写真チェック
            deletePhotoAllCheck(){
                for (let i = 0, l = this.userImages.length; i < l; i++) {
                    this.selectedDeletePhotoId.push(this.userImages[i])
                }
            },
            deletePhotoCheckClear(){
                this.selectedDeletePhotoId = [];
            },
            checkPhotoDelete(){
                if(this.selectedDeletePhotoId.length){
                    if (confirm('チェックされた写真を削除します。よろしいですか？')) {

                    }
                }
            },
        },
    }
</script>

<style scoped>

</style>