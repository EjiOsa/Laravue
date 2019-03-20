<template>
    <div>
        <div class="split-box left-box">
            <h2>Photo Management</h2>
            <p>ユーザーフォルダへの振り分けページ
            <br>スプリット画面
            <br>左はユーザーフォルダ、フォルダ一覧ページかフォルダ内の詳細ページになる。詳細ページはユーザーの写真一覧ページを流用。
            <br>右は写真保存ページの左側の部分をそのまま流用する。</p>
            <photo-folder-base
            :token-data="tokenData"
            ></photo-folder-base>
        </div>
        <div class="split-box right-box">
            <event-folder-base
            :token-data="tokenData"
            ></event-folder-base>
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
    </div>
</template>

<script>
    // import PhotoFolder from './folder_conponent/Folder'
    import PhotoFolderBase from './folder_conponent/PhotoFolderBase'
    import EventFolderBase from './save_component/EventFolderBase'
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
            // Folder,
            PhotoFolderBase,
            EventFolderBase,
            // ThumbnailPhoto,
        },
        props:{
            tokenData: {
                type: String,
                required: true
            }
        },
        computed:{
            // tokenNo() {
            //     return this.tokenData
            // }
        },
        data () {
            return {
                // images: [],

                // userImages: [],
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
            // remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
            //     for(var i = 0; i < base.length ; i++){
            //         base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
            //     }
            //     data = base;
            // },
            // async userImage(user_id){
            //     const UserPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation/'+user_id;
            //     const UserPhotoAxios = require('axios').create({
            //         baseURL: UserPhotoUrl,
            //     });
            //     UserPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            //     await UserPhotoAxios.get()
            //         .then(response => (this.userImages = response.data));
            //     this.remakeData(this.userImages, this.userImages);
            // }
        },
    }
</script>

<style scoped>
    .split-box{
        display: table;
        position:absolute;
        width:50%;
        height:100%;
    }

    .left-box {
        /*width:50%;*/
        left:0;
        overflow-y:scroll;
    }

    .right-box {
    /*width:50%;*/
    right:0;
    /*overflow-y:scroll;*/
    }
</style>