<template>
    <div class="split-box right-box">
        <button
                class="btn btn-light"
                @click="showForm =! showForm"
                @dragover.prevent="dragOver"
                @dragleave.prevent>
            <i>
                Select Photo
            </i>
        </button>
        <nav class="navbar">
            <photo-form v-model="showForm"></photo-form>
        </nav>
        <div class="row">
            <thumbnail-photo
                        v-for="image in prepare_images"
                        :key="image.name"
                        :image="image"
            ></thumbnail-photo>
        </div>
        <div>
            <select-box
                :events="events_name"
            ></select-box>
        </div>
        <div>
            <button class="btn btn-light" @click.prevent="addPhoto" v-if="showForm">追加</button>
        </div>
    </div>
</template>

<script>
    import PhotoForm from './PhotoForm'
    import ThumbnailPhoto from './ThumbnailPhoto'
    import SelectBox from './SelectBox'

    const PhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photos';
    const Axios = require('axios').create({
        baseURL: PhotoUrl,
    });

    const EventsUrl = 'http://localhost/photo_share/laravue_test1/public/api/events';
    const EventAxios = require('axios').create({
        baseURL: EventsUrl,
    });
    EventAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "SubmitPhoto",
        components:{
            PhotoForm,
            ThumbnailPhoto,
            SelectBox
        },
        props:{
            tokenData: {
                type: String,
            }
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data(){
            return{
                showForm: false,
                prepare_images:[],
                events_data: [],
                events_name: [],
                add_event: '',
            }
        },
        async mounted () {
            EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await EventAxios.get()
                .then(response => (
                    this.events_data = response.data
                ));
            for(var i = 0; i < this.events_data.length ; i++){
                this.events_name.push(this.events_data[i].name);
            }
        },
        methods:{
            dragOver(){
                this.showForm = true;
            },
            async addPhoto () {//DBへPhotoの追加
                let formData = new FormData();
                let len = this.prepare_images.length;
                if(!this.prepare_images.length) {
                    //imagesに中身がない時

                }else{
                    //imagesに中身がある時
                    for (var i = 0;i < len ;i++){
                        formData.append('photo'+i, this.prepare_images[i].uploadFile);
                        // formData.append('name', this.images[i].name);//名前とかユニーク化をどうするか。
                    }
                    formData.append('len', len);
                    formData.append('event_name', this.add_event);
                }
                Axios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await Axios.post('', formData)
                    .then(
                        alert('photo add ok'),
                    )
                    .catch(function (err) {
                        alert(err);
                    });
                },
        }
    }
</script>

<style scoped lang="scss">
    @import '../resources/sass/app';

    .split-box{
        position:absolute;
        z-index: 10;
        height:74%;
        padding:1em;
        top: 100px;
        background-color: $base-color_6;
    }
    .right-box {
        box-sizing: border-box;
        margin-top: 105px;
        padding: 1% 2%;
        width:70%;
        right:0;
        overflow-y:scroll;
    }
</style>