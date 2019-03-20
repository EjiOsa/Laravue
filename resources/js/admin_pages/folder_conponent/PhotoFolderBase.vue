<template>
    <div>
        <ul>
            <thumbnail-photo
                    v-for="image in userImages"
                    :key="image.name"
                    :image="image"
                    v-show="!showFolder"
            ></thumbnail-photo>
        </ul>
        <ul>
            <folder
                    v-for="user in users"
                    :key="user.id"
                    :folderData="user"
                    v-show="showFolder"
                    @image = "userImage"
            ></folder>
        </ul>
        <div>
            <button class="" @click.prevent="backList" v-show="!showFolder">メンバーリストに戻る</button>
        </div>
    </div>
</template>

<script>
    import Folder from './Folder'
    import ThumbnailPhoto from '../../../../ゴミ箱/ThumbnailPhoto'

    const ApiUrl = 'http://localhost/photo_share/laravue_test1/public/api/users';
    const ApiAxios = require('axios').create({
        baseURL: ApiUrl,
    });
    ApiAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "ParentFolder",
        components:{
            Folder,
            ThumbnailPhoto,
        },
        props:{
            tokenData: {
                type: String,
                required: true
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
                userImages: [],
                showFolder: true,
            };
        },
        async mounted () {
            ApiAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await ApiAxios.get()
                .then(response => (this.users = response.data));
        },
        methods: {
            remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
                for(var i = 0; i < base.length ; i++){
                    base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
                }
                data = base;
            },
            async userImage(user_id){
                const UserPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation/'+user_id;
                const UserPhotoAxios = require('axios').create({
                    baseURL: UserPhotoUrl,
                });
                UserPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await UserPhotoAxios.get()
                    .then(response => (this.userImages = response.data));
                this.remakeData(this.userImages, this.userImages);
            },
            backList(){
                this.showFolder = true;
                this.eventImages = [];
            }
        },
    }
</script>

<style scoped>

</style>