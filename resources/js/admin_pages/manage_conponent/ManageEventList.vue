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
                            @dragstart="movePhoto(selectedMovePhotoId)"
                            @dragend="dragEnd"
                    ></v-img>
                    <v-card-actions class="px-1 py-0">
                        <v-checkbox
                                v-model="selectedMovePhotoId"
                                :value=image
                                class="pa-0 ma-1"
                        >
                        </v-checkbox>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout justify-end>
            <v-btn
                    color="grey lighten-4"
                    @click="movePhotoAllCheck"
                    v-show="!showList"
            >All Check</v-btn>
            <v-btn
                    color="grey lighten-4"
                    @click="movePhotoCheckClear"
                    v-show="!showList"
            >Check Clear</v-btn>
        </v-layout>
        <v-layout justify-end>
            <v-btn
                    color="blue-grey lighten-4"
                    @click="backList"
                    v-show="!showList"
            >Back to Event List</v-btn>
        </v-layout>
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
                selectedMovePhotoId:[],
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
            movePhoto(ids){
                if (!ids.length) {
                    //写真のチェックがないままドロップした時
                    alert('写真が選択されていません。');//ドロップの開始時でアラート設定
                } else {
                    this.$parent.DragDropTrigger = true;
                    let idStrList = '';
                    for (let i = 0, l = ids.length; i < l; i++) {
                        idStrList = idStrList + (ids[i].id) + ',';
                    }
                    idStrList = idStrList.replace(/,$/, '');
                    event.dataTransfer.setData("text", idStrList);
                }
            },
            dragEnd(){
                this.$parent.DragDropTrigger = false;
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
                this.selectedMovePhotoId = [];
            },
            //イベント写真の一括チェック処理
            movePhotoAllCheck(){
                for (let i = 0, l = this.eventImages.length; i < l; i++) {
                    this.selectedMovePhotoId.push(this.eventImages[i])
                }
            },
            movePhotoCheckClear(){
                this.selectedMovePhotoId = [];
            },
        },
    }
</script>

<style scoped>

</style>

<!--
==================リファクタリング==================
・イベント内の写真リストの大きさを調整
・チェックされた写真たちをドラッグ時に表示させたい。アニメーションさせたい。
-->