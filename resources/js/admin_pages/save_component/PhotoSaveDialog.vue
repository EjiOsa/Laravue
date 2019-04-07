<template>
    <v-layout row justify-center>
        <v-dialog
                v-model="photoSaveDialog"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
        >
            <v-card>
                <!--ツールバー-->
                <v-toolbar
                        dark
                        fixed
                        color="blue-grey darken-2"
                >
                    <v-btn icon dark @click="saveDialogClose">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>『{{selectEvent.name}}』 Photo Management</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
　　　　　　　　　　<!--写真選択-->
                <v-divider dark></v-divider>
                <v-divider dark></v-divider>
                <v-container
                        fluid
                        grid-list-md
                        @dragover.prevent="dragOver"
                        @dragleave.prevent="dragLeave"
                        @drop.prevent="onFileChange($event)"
                        mt-5
                        class="blue-grey lighten-5"
                >
                    <div>
                        <h4>Select Photo or Drop Photo Here</h4>
                    </div>
                    <v-btn color="blue-grey lighten-4"  @click="$refs.inputUpload.click()">Select Photo
                        <!--inputにrefで紐付け-->
                        <input
                                type="file"
                                multiple
                                accept="image/*"
                                @change="onFileChange($event)"
                                ref="inputUpload"
                                v-show="false">
                    </v-btn>
                </v-container>
                <v-divider></v-divider>
　　　　　　　　　　<!--写真保存待機-->
                <v-container
                        fluid
                        grid-list-md
                >
                    <v-flex>
                        <h4>StandBy Photo</h4>
                    </v-flex>
                    <v-layout row wrap>
                        <v-flex
                                v-for="image in prepareImages"
                                :key="image.name"
                                align-self-center
                                xs12
                                sm6
                                md4
                                lg3
                        >
                            <v-card>
                                <v-img :src="image.photo"></v-img>
                                <v-card-actions class="pa-1">
                                    <!--<v-btn icon @click="">-->
                                        <!--<v-icon>edit</v-icon>-->
                                    <!--</v-btn>-->
                                    <v-checkbox
                                            v-model="selectedPreparePhotoId"
                                            :value=image.unique
                                    >
                                    </v-checkbox>
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="standByPhotoClear(image.unique)">
                                        <v-icon>clear</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-layout>
                    <v-btn
                            color="grey lighten-4"
                            @click="photoRegistration"
                    >
                        Photo Registration
                    </v-btn>
                    <v-layout justify-end>
                        <v-btn
                                color="grey lighten-4"
                                @click="preparePhotoAllCheck"
                        >
                            All Check</v-btn>
                        <v-btn
                                color="grey lighten-4"
                                @click="preparePhotoCheckClear"
                        >
                            Check Clear</v-btn>
                        <v-btn
                                color="blue-grey lighten-3"
                                @click="preparePhotoDelete"
                        >
                            StandBy Photo Delete</v-btn>
                    </v-layout>
                </v-container>
                <v-divider></v-divider>
　　　　　　　　　　<!--保存済み写真-->
                <v-container
                        fluid
                        grid-list-md
                >
                    <div>
                        <h4>Keep Photo</h4>
                    </div>
                    <v-layout row wrap>
                        <v-flex
                                v-for="image in eventImages"
                                :key="image.id"
                                align-self-center
                                xs12
                                sm6
                                md4
                                lg3
                        >
                            <!--align-self-centerで上下の中央揃え-->
                            <v-card>
                                <v-img :src="image.photo"></v-img>
                                <v-card-actions class="pa-1">
<!--                                    <v-layout>-->
                                    <v-checkbox
                                            v-model="selectedKeepPhoto"
                                            :value=image
                                    >
                                    </v-checkbox>
<!--                                    </v-layout>-->
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="photoDetailOpen(image)">
                                        <v-icon>open_in_browser</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="keepPhotoDelete(image)">
                                        <v-icon>delete</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-layout>
                    <v-layout justify-end>
                        <v-btn
                                color="grey lighten-4"
                                @click="keepPhotoAllCheck"
                        >
                            All Check</v-btn>
                        <v-btn
                                color="grey lighten-4"
                                @click="keepPhotoCheckClear"
                        >
                            Check Clear</v-btn>
                        <v-btn
                                color="blue-grey lighten-3"
                                @click="keepPhotoListDelete"
                        >
                            Check Photo Delete</v-btn>
                    </v-layout>
                </v-container>
            </v-card>
        </v-dialog>
        <detail-dialog
                :detail-data ="photoDetailData"
                ref="detailDialog"
        >
        </detail-dialog>
    </v-layout>
</template>

<script>
    import DetailDialog from './PhotoDetailDialog'

    const PhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photos';
    const PhotoAxios = require('axios').create({
        baseURL: PhotoUrl,
    });

    export default {
        name: "PhotoSaveDialog",
        components:{
            DetailDialog
        },
        props:{
            selectEvent:{
              type:String,
            },
            eventImages:{
                type:Object,
            },
            tokenData: {
                type: String,
            },
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data () {
            return {
                photoDetailData: [],
                photoSaveDialog: false,
                prepareImages:[],
                selectedPreparePhotoId:[],
                selectedKeepPhoto:[],
            }
        },
        methods: {
            //Save用Dialogのクローズ処理
            saveDialogClose() {
                if (this.prepareImages.length) {//登録待機の写真がある時だけ、アラートで確認。
                    if (confirm('登録待機の写真はリセットされます。よろしいですか？')) {
                        this.$parent.eventImages = {};
                        this.prepareImages = [];
                        this.photoSaveDialog = false;
                    }
                } else {
                    this.$parent.eventImages = {};
                    this.prepareImages = [];
                    this.photoSaveDialog = false;
                }
            },
            //画像を選択またはドラッグされた時の処理
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;//inputのファイル（画像）はfileListって名前のオブジェクトで渡される。
                //targetはinputタグから取得の画像、dataTransferはdropからの画像。
                if (files.length) {
                    for (let i = 0; i < files.length; i++) {//fileListを渡した先の関数で展開しようとすると、非同期のために（？）展開が先に走って画像が出ない。
                        this.imageStandBy(files[i]);//先にこっちで展開して、関数はデータの処理に専念させる。
                    }
                }
            },
            imageStandBy(file) {
                let reader = new FileReader();
                let obj = {};
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    let date = new Date();
                    obj.photo = e.target.result;
                    obj.uploadFile = file;
                    obj.name = file.name;
                    obj.unique = file.name + date.getTime();//削除用に名前とタイムスタンプでユニークにした。
                    this.prepareImages.push(obj);
                };
            },
            //DBへPhotoの登録
            async photoRegistration() {
                let formData = new FormData();//FormDataはHTML5の機能
                let len = this.prepareImages.length;
                if (!len) {
                    //prepareImagesに中身がない時
                    alert('写真が選択されていません。');
                } else {
                    //prepareImagesに中身がある時
                    for (let i = 0; i < len; i++) {
                        formData.append('photo' + i, this.prepareImages[i].uploadFile);
                    }
                    formData.append('len', len);
                    formData.append('event_id', this.selectEvent.id);//リレーション用にイベントIDを渡す。

                    PhotoAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                    await PhotoAxios.post('', formData)
                        .then(
                            alert('photo registration ok'),
                        )
                        .catch(function (err) {
                            alert(err);
                        });
                    //以下、写真の再レンダリング
                    this.prepareImages = [];
                    this.$parent.eventImages = {};
                    this.$parent.eventImageGet(this.selectEvent.id);
                    this.$parent.eventReset();
                }
            },
            //スタンバイの写真の一斉処理
            preparePhotoDelete(){
                for(let i = 0; i < this.selectedPreparePhotoId.length; i++){
                    this.standByPhotoClear(this.selectedPreparePhotoId[i]);
                }
                this.selectedPreparePhotoId = [];
            },
            preparePhotoAllCheck(){
                for (let i = 0; i < this.prepareImages.length; i++) {
                    this.selectedPreparePhotoId.push(this.prepareImages[i].unique);
                }
            },
            preparePhotoCheckClear(){
                this.selectedPreparePhotoId = [];
            },
            //保存済み写真の一斉処理
            async keepPhotoListDelete(){
                if (confirm('チェックされた写真を削除します。よろしいですか？')) {
                    if(this.selectedKeepPhoto.length>0){
                    for (let i = 0; i < this.selectedKeepPhoto.length; i++) {
                        PhotoAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                        await PhotoAxios.delete(PhotoUrl+'/'+this.selectedKeepPhoto[i].id)
                            .then(
                            )
                            .catch(function (err) {
                                alert(err);
                            });
                    }
                    this.$parent.eventImages = {};
                    this.$parent.eventImageGet(this.selectEvent.id);
                    this.$parent.eventReset();
                    this.selectedKeepPhoto = [];
                    alert('photo delete ok');
                }else{
                        alert('写真が選択されていません。')
                    }
                }
            },
            keepPhotoAllCheck(){
                for (let i = 0; i < this.eventImages.length; i++) {
                    this.selectedKeepPhoto.push(this.eventImages[i])
                }
            },
            keepPhotoCheckClear(){
                this.selectedKeepPhoto = [];
            },
            //ドラッグ操作
            dragOver() {

            },
            dragLeave() {

            },
            //Photoアイコン操作
            standByPhotoClear(uni) {
                let self = this;//下のようなコールバック関数の中ではthisは使用できないので、thisを変数に格納する。
                this.prepareImages.some(function(v, i){//この関数は今後の課題、よく理解できていない。
                    if (v.unique === uni) {
                        self.prepareImages.splice(i, 1);//spliceは第一引数にindexで削除開始位置、第二引数は個数。第二引数を2にすると二つ削除される。
                    }
                });
            },
            async keepPhotoDelete(image){
                if (confirm('写真を削除します。よろしいですか？')) {
                    PhotoAxios.defaults.headers['Authorization'] = 'Bearer ' + this.tokenNo;
                    await PhotoAxios.delete(PhotoUrl+'/'+image.id)
                        .then(
                            alert('photo delete ok'),
                        )
                        .catch(function (err) {
                            alert(err);
                        });
                    this.$parent.eventImages = {};
                    this.$parent.eventImageGet(this.selectEvent.id);
                    this.$parent.eventReset();
                }
            },
            photoDetailOpen(image){
                this.photoDetailData = image;
                this.$refs.detailDialog.photoDialog = true;
            },
        }
    }
</script>

<style scoped>

</style>

<!--
===============リファクタリング===============
・ドラッグ＆ドロップのデザインを考える。
・<v-divider dark></v-divider>で上端のスペースを確保。なんか間違ってる。
・229行目の関数は今後の課題。
・画像選択で同じものを選択する（複数でも）と反応しない。
・selectボタンたちは中央に、registrationボタンは右寄せにする。
-->