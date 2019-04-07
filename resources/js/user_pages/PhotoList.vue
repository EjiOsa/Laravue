<template>
    <v-container
            fluid
            grid-list-md
    >
        <div>
            <h2>Your PhotoList</h2>
        </div>
        <v-layout row wrap>
            <v-flex
                    v-for="image in userImages"
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
                        <v-checkbox
                                v-model="selectedPhotoId"
                                :value=image.id
                        >
                        </v-checkbox>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="photoDetailOpen(image)">
                            <v-icon>open_in_browser</v-icon>
                        </v-btn>
                        <!--<v-btn icon @click="keepPhotoDelete(image)">-->
                            <!--<v-icon>delete</v-icon>-->
                        <!--</v-btn>-->
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <detail-dialog
                :detail-data ="photoDetailData"
                ref="detailDialog"
        >
        </detail-dialog>
        <v-btn
                color="grey lighten-4"
                @click="photoAllCheck"
        >
            All Check
        </v-btn>
        <v-btn
                color="grey lighten-4"
                @click="checkClear"
        >
            Clear Check
        </v-btn>
        <v-btn
                color="grey lighten-4"
                @click="photoDownLoad"
        >
            Photo DownLoad
        </v-btn>
    </v-container>
</template>

<script>
    import DetailDialog from '../admin_pages/save_component/PhotoDetailDialog'

    export default {
        name: "PhotoList",
        components:{
            DetailDialog
        },
        props: {
            tokenData: {
                type: String,
                required: true,
                // source: String
            },
            userId: {
                type: String
            }
        },
        computed:{
            tokenNo() {
                return this.tokenData
            }
        },
        data () {
            return {
                userImages:{},
                photoDetailData: [],
                selectedPhotoId:[],
            }
        },
        async created(){
            const UserPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation/'+this.userId;
            const UserPhotoAxios = require('axios').create({
                baseURL: UserPhotoUrl,
            });
            UserPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UserPhotoAxios.get()
                .then(response => (this.userImages = response.data));
            this.remakeData(this.userImages, this.userImages);
        },
        methods:{
            remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
                for(let i = 0; i < base.length ; i++){
                    base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
                }
                data = base;
            },
            photoDetailOpen(image){
                this.photoDetailData = image;
                this.$refs.detailDialog.photoDialog = true;
            },
            photoDownLoad(){
              alert(this.selectedPhotoId);


              this.selectedPhotoId = [];
            },
            //写真の一斉処理
            photoAllCheck(){
                for (let i = 0; i < this.userImages.length; i++) {
                    this.selectedPhotoId.push(this.userImages[i].id)
                }
            },
            checkClear(){
                this.selectedPhotoId = [];
            }
        }
    }
</script>

<style scoped>

</style>
<!--
==================リファクタリング========================
・チェックボックスの配置を修正
・

-->