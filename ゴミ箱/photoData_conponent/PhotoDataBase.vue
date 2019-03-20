<template>
    <div class="split-box side-bar">
        <div class="row">
            <thumbnail-photo
                v-for="image in images"
                :key="image.name"
                :image="image"
            ></thumbnail-photo>
        </div>
    </div>
</template>

<script>
    import ThumbnailPhoto from '../ThumbnailPhoto'

    const PhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photos';
    const Axios = require('axios').create({
        baseURL: PhotoUrl,
    });

    export default {
        name: "PhotoDataBase",
        components:{
            ThumbnailPhoto
        },
        props:{
            tokenData: {
                type: String,
                // required: true
            }
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data () {
            return {
                images: [],
            };
        },
        async mounted () {
            Axios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await Axios.get()
                .then(response => (this.images = response.data));
            this.remakeData(this.images);
        },
        methods: {
            remakeData(base){
                for(var i = 0; i < base.length ; i++){
                    base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;
                }
                this.images = base;
            }
        },
    }
</script>

<style scoped lang="scss">
    @import '../../resources/sass/app';
    /*.split-box{*/
        /*!*position:absolute;*!*/
        /*z-index: 100;*/
        /*padding:1em;*/
        /*top: 50px;*/
    /*}*/
    /*.side-bar {*/
        /*width:30%;*/
        /*left:0;*/
        /*overflow-y:scroll;*/
    /*}*/
</style>