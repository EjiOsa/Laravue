<template>
    <v-container
            fluid
            grid-list-md
    >
        <v-layout row wrap>
            <v-flex
                    v-for="event in events"
                    :key="event.id"
                    xs12
                    sm6
                    md3
                    lg2
            >
                <v-card
                        @dblclick=openPhotoSave(event)
                >
                    <span class="headline black--text" v-text="event.name"></span>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="eventEdit(event)">
                            <v-icon>edit</v-icon>
                        </v-btn>
                        <v-btn icon @click="eventDelete(event.id)">
                            <v-icon>clear</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <!--<ul>-->
                <!--<thumbnail-photo-->
                        <!--v-for="image in eventImages"-->
                        <!--:key="image.name"-->
                        <!--:image="image"-->
                        <!--v-show="!showFolder"-->
                <!--&gt;</thumbnail-photo>-->
            <!--</ul>-->
            <!--<v-btn @click.prevent="backList" v-show="!showFolder">イベントリストに戻る</v-btn>-->
        </v-layout>
    </v-container>
    <!--<div>-->
        <!--<ul>-->
            <!--<thumbnail-photo-->
                    <!--v-for="image in eventImages"-->
                    <!--:key="image.name"-->
                    <!--:image="image"-->
                    <!--v-show="!showFolder"-->
            <!--&gt;</thumbnail-photo>-->
        <!--</ul>-->
        <!--<ul>-->
            <!--<folder-->
                    <!--v-for="event in events"-->
                    <!--:key="event.id"-->
                    <!--:folderData="event"-->
                    <!--v-show="showFolder"-->
                    <!--@image = "eventImage"-->
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

    const EventsUrl = 'http://localhost/photo_share/laravue_test1/public/api/events';
    const EventAxios = require('axios').create({
        baseURL: EventsUrl,
    });
    EventAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "EventList",
        components:{
            // Folder,
            // ThumbnailPhoto,
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
                events:{},
                // eventImages: [],
                // showFolder: true,
            };
        },
        async mounted () {
            EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await EventAxios.get()
                .then(response => (
                    this.events = response.data
                ));
                // .catch(err => (//リファクタリング、2回呼んでいて2回目にエラーを吐いてる。
                //     alert(err)
                // ));
        },
        methods: {
            // remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
            //     for(var i = 0; i < base.length ; i++){
            //         base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
            //     }
            //     data = base;
            // },
            // async eventImage(event_id){
            //     this.showFolder = false;
            //     const EventPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/event_photo_relation/'+event_id;
            //     const EventPhotoAxios = require('axios').create({
            //         baseURL: EventPhotoUrl,
            //     });
            //     EventPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            //     await EventPhotoAxios.get()
            //         .then(response => (this.eventImages = response.data));
            //     this.remakeData(this.eventImages, this.eventImages);
            // },
            // backList(){
            //     this.showFolder = true;
            //     this.eventImages = [];
            // },

            listUpload(){
                EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                EventAxios.get()
                    .then(response => (
                        this.events = response.data
                    ));
            },
            eventDelete(id){
                if (confirm('イベントを削除しますか？')) {
                    if (confirm('本当にイベントを削除しますか？\nイベント内の画像も削除されます。')) {
                        if (confirm('このイベントからユーザーへ渡した画像も削除されます。\nイベントを削除しますか？')) {
                            this.$emit('event-delete', id);
                        }
                    }
                }
            },
            eventEdit(event){
                if (confirm('イベント名を編集しますか？')) {
                    this.$emit('event-edit', event);
                }
            },
            openPhotoSave(event){
                this.$emit('open-photo-save', event);
            }
        },
    }
</script>

<style scoped>

</style>
<!--
====================リファクタリング====================
・grid-listsにあるアルバムのように、フォルダの表紙に中の写真の6枚ぐらいを表示させる。
・イベント名はアルバムの大きさによって、文字数制限をかけてしまえば大きさの崩れはなくなる。

-->