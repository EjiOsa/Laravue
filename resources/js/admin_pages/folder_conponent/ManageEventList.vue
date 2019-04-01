<template>
    <v-container
            fluid
            grid-list-md
    >
        <h2 v-show="showList">Event List</h2>
        <h2 v-show="!showList">{{listTitle}}'s Photo List</h2>
        <v-layout row wrap>
            <v-flex
                    v-show="showList"
                    v-for="event in events"
                    :key="event.id"
                    xs12
                    sm6
                    md4
                    lg3
            >
                <v-card
                        @dblclick=openEventPhoto(event)
                >
                    <!--<span class="headline black&#45;&#45;text" v-text="event.name"></span>-->
                    <v-card-title><h5>{{event.name}}</h5></v-card-title>
                    <v-divider></v-divider>
                    <v-list dense>
                        <v-list-tile>
                            <v-list-tile-content>Photos:</v-list-tile-content>
                            <v-list-tile-content class="align-end">{{event.photo_count}}</v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex
                    v-for="image in eventImages"
                    :key="image.id"
                    align-self-center
                    xs12
                    sm8
                    md6
                    lg4
            >
                <!--align-self-centerで上下の中央揃え-->
                <v-card>
                    <v-img
                            :src="image.photo"
                            draggable="true"
                            @dragstart="movePhoto(image)"
                    ></v-img>
                    <!--<v-card-actions>-->
                        <!--<v-spacer></v-spacer>-->
                        <!--<v-btn icon @click="photoDetailOpen(image)">-->
                            <!--<v-icon>open_in_browser</v-icon>-->
                        <!--</v-btn>-->
                        <!--<v-btn icon @click="keepPhotoDelete(image)">-->
                            <!--<v-icon>delete</v-icon>-->
                        <!--</v-btn>-->
                    <!--</v-card-actions>-->
                </v-card>
            </v-flex>
        </v-layout>
        <v-btn
                color="blue-grey lighten-4"
                @click="backList"
                v-show="!showList"
        >Back to Event List</v-btn>
    </v-container>
</template>

<script>
    const EventsUrl = 'http://localhost/photo_share/laravue_test1/public/api/events';
    const EventAxios = require('axios').create({
        baseURL: EventsUrl,
    });
    EventAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "ManageEventList",
        components:{
            // Folder,
            // ThumbnailPhoto,
        },
        props:{
            tokenData: {
                type: String,
                required: true
            },
            eventImages:{
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
                events:{},
                showList: true,
                listTitle:'',
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
            //ドラッグスタート処理
            movePhoto(image){
                event.dataTransfer.setData("text", image.id);
            },
            //ダブルクリック処理
            openEventPhoto(event){
                this.listTitle = event.name;
                this.showList =false;
                this.$emit('open-event-photo', event);
            },
            //リストへ戻る
            backList(){
                this.showList =true;
                this.$parent.eventImages =[];
            },

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
            //
            // listUpload(){
            //     EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            //     EventAxios.get()
            //         .then(response => (
            //             this.events = response.data
            //         ));
            // },
            // eventDelete(id){
            //     if (confirm('イベントを削除しますか？')) {
            //         if (confirm('本当にイベントを削除しますか？\nイベント内の画像も削除されます。')) {
            //             if (confirm('このイベントからユーザーへ渡した画像も削除されます。\nイベントを削除しますか？')) {
            //                 this.$emit('event-delete', id);
            //             }
            //         }
            //     }
            // },
            // eventEdit(event){
            //     if (confirm('イベント名を編集しますか？')) {
            //         this.$emit('event-edit', event);
            //     }
            // },
        },
    }
</script>

<style scoped>

</style>

<!--
==================リファクタリング==================
・イベント内の写真リストの大きさを調整

-->