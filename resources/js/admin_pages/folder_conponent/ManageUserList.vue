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
                    <span class="headline black--text" v-text="user.first_name"></span>
                    <v-card-actions>
                        <!--<v-spacer></v-spacer>-->
                        <!--<v-btn icon @click="eventEdit(event)">-->
                        <!--<v-icon>edit</v-icon>-->
                        <!--</v-btn>-->
                        <!--<v-btn icon @click="eventDelete(event.id)">-->
                        <!--<v-icon>clear</v-icon>-->
                        <!--</v-btn>-->
                    </v-card-actions>
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
                <v-card>
                    <v-img :src="image.photo"></v-img>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <!--<v-btn icon @click="photoDetailOpen(image)">-->
                        <!--<v-icon>open_in_browser</v-icon>-->
                        <!--</v-btn>-->
                        <!--<v-btn icon @click="keepPhotoDelete(image)">-->
                        <!--<v-icon>delete</v-icon>-->
                        <!--</v-btn>-->
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-btn
                color="blue-grey lighten-4"
                @click="backList"
                v-show="!showList"
        >Back to User List</v-btn>
    </v-container>
    <!--<div>-->
        <!--<ul>-->
            <!--<thumbnail-photo-->
                    <!--v-for="image in userImages"-->
                    <!--:key="image.name"-->
                    <!--:image="image"-->
                    <!--v-show="!showFolder"-->
            <!--&gt;</thumbnail-photo>-->
        <!--</ul>-->
        <!--<ul>-->
            <!--<folder-->
                    <!--v-for="user in users"-->
                    <!--:key="user.id"-->
                    <!--:folderData="user"-->
                    <!--v-show="showFolder"-->
                    <!--@image = "userImage"-->
            <!--&gt;</folder>-->
        <!--</ul>-->
        <!--<div>-->
            <!--<button class="" @click.prevent="backList" v-show="!showFolder">メンバーリストに戻る</button>-->
        <!--</div>-->
    <!--</div>-->
</template>

<script>
    // import Folder from './Folder'
    // import ThumbnailPhoto from '../../../../ゴミ箱/ThumbnailPhoto'

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
            };
        },
        async mounted () {
            UserAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UserAxios.get()
                .then(response => (this.users = response.data));
        },
        methods: {
            //ドロップ
            async photoDrop(user){
                let photoId = event.dataTransfer.getData("text");
                let userId = user.id;
                let formData = new FormData();

                formData.append('user_id', userId);
                formData.append('photo_id', photoId);

                PhotoUserAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                await PhotoUserAxios.post('', formData)
                    .then(
                        alert('photo relation ok'),
                    )
                    .catch(function (err) {
                        alert(err);
                    });
            },
            //ユーザーの画像表示
            openUserPhoto(user){
                this.listTitle = user.first_name;
                this.showList =false;
                this.$emit('open-user-photo', user);
            },
            //リストに戻る
            backList(){
                this.showList = true;
                this.$parent.userImages = [];
            },

        },
    }
</script>

<style scoped>

</style>