<template>
    <div>
        <h2>Photo Save</h2>
        <v-btn color="blue-grey lighten-4" @click="dialogOpen">New Event</v-btn>
        <v-container
            fluid
            grid-list-md
        >
            <v-layout xs6>
                <event-list
                        :token-data="tokenData"
                        ref="eventFolder"
                        @event-delete = "eventDelete"
                        @event-edit = "eventEdit"
                        @open-photo-save="openPhotoSave"
                ></event-list>
            </v-layout>
        </v-container>
        <new-event-dialog
                :token-data="tokenData"
                :new-event="newEvent"
                :event-name-list="eventNameList"
                @event-addition="eventAddition"
                ref="open"
        ></new-event-dialog>
        <save-dialog
                :token-data="tokenData"
                :select-event="selectEvent"
                :event-images="eventImages"
                ref="saveDialog"
        ></save-dialog>
    </div>
</template>

<script>
    import EventList from './save_component/EventList'
    import NewEventDialog from './save_component/NewEventDialog'
    import SaveDialog from './save_component/PhotoSaveDialog'

    // const PhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photos';
    // const Axios = require('axios').create({
    //     baseURL: PhotoUrl,
    // });
    const h = new Date();
    const year = h.getFullYear();
    const month = h.getMonth()+1;
    const day = h.getDate();
    const today = year+'.'+month+'.'+day;

    const EventsUrl = 'http://localhost/photo_share/laravue_test1/public/api/events';
    const EventAxios = require('axios').create({
        baseURL: EventsUrl,
    });
    EventAxios.defaults.headers['Accept'] = 'application/json';

    export default {
        name: "PhotoSave",
        components:{
            EventList,
            NewEventDialog,
            SaveDialog
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
                newEvent:{},
                eventList:{},
                eventNameList:[],
                selectEvent:'',
                eventImages:{},
            };
        },
        async mounted () {
            EventAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
            await EventAxios.get()
                .then(response => (
                    this.eventList = response.data
                ));
            let l = this.eventList.length;
            for(var i=0; i<l; ++i){
                this.eventNameList.push(this.eventList[i].name)
            }
        },
        methods: {
            //イベント名の更新
            async eventUpdate (event) {
                EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await EventAxios.put(EventsUrl+'/'+event.id, event)
                    .then(
                        alert('イベント名の更新に成功しました')
                    )
                    .catch(function (err) {
                        alert(err)
                    });
                this.eventReset();
            },
            //イベントの追加
            async eventRegistration(){
                EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await EventAxios.post('', this.newEvent)
                    .then(
                        alert('event add　ok')
                    )
                    .catch(function (err) {
                        alert(err)
                    });
                this.$refs.eventFolder.listUpload();
            },
            //イベントの削除
            async eventDelete(id){
                EventAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                await EventAxios.delete(EventsUrl+'/'+id)
                    .then(
                        alert('event delete')
                    )
                    .catch(function (err) {
                                alert(err)
                    });
                this.$refs.eventFolder.listUpload();
            },
            //イベント名の編集振り分け
            eventAddition () {
                if (this.$refs.eventFolder.events.find(events => events.id === this.newEvent.id)) { //events内にidが存在する＝＞更新の場合
                    if (confirm('イベント名を更新しますか？')) {
                        this.eventUpdate(this.newEvent);
                        this.newEvent = {};
                    }
                } else { // events内にidが存在しない＝＞追加の場合
                    if (confirm('イベントを追加しますか？')) {
                        this.eventRegistration();
                    }
                }
            },
            //DiaLog Event Open
            dialogOpen(){//新規用
                this.newEvent.name = today;
                this.$refs.open.eventNameDialog = true;
            },
            eventEdit(event){//編集用
                this.newEvent = Object.assign({}, event);
                this.$refs.open.eventNameDialog = true;
            },

            remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
                    for(var i = 0; i < base.length ; i++){
                        base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
                    }
                    data = base;
                },
            async eventImageGet(event_id){
                    this.showFolder = false;
                    const EventPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/event_photo_relation/'+event_id;
                    const EventPhotoAxios = require('axios').create({
                        baseURL: EventPhotoUrl,
                    });
                    EventPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
                    await EventPhotoAxios.get()
                        .then(response => (this.eventImages = response.data));
                    this.remakeData(this.eventImages, this.eventImages);
                },
            //Photo Save Dialog Open
            openPhotoSave(event){
                this.selectEvent = event;
                this.eventImageGet(event.id);
                this.$refs.saveDialog.photoSaveDialog = true;
            },
            //Eventの再レンダリング
            eventReset(){
                this.$refs.eventFolder.listUpload();
            }

        },
    }
</script>

<style scoped>

</style>

<!--
==================リファクタリング==================


-->
