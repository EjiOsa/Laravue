<template>
    <v-layout row justify-center>
        <v-dialog v-model="detailDialog" width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{detailData.family_name}} {{detailData.first_name}}</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-list dense>
                    <v-list-tile>
                        <v-list-tile-content>UserId:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{detailData.id}}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-content>Age:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{detailData.age}}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-content>Email:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{detailData.email}}</v-list-tile-content>
                    </v-list-tile>
                    <v-divider></v-divider>
                    <v-list-tile>
                        <v-list-tile-content><h4>Photos:</h4></v-list-tile-content>
                        <!--<v-list-tile-content></v-list-tile-content>-->
                    </v-list-tile>
                    <dialog-images
                            :user-images="userImages"
                    ></dialog-images>
                </v-list>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat="flat" @click="closeDialog">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import DialogImages from './DialogImages'
    export default {
        name: "UserDetailDialog",
        components:{
          DialogImages,
        },
        props:{
            detailDialog:{
                type:Boolean
            },
            detailData:{
                type:Object
            },
            tokenData:{
                type: String,
                required: true
            },
            userImages: {
                type:Object
            },
        },
        computed:{
        },
        data(){
            return{
            }
        },
        methods:{
            closeDialog(){
                // this.$parent.userImages = {};上で表示前に消しているのでここでは不要に。
                this.$parent.detailDialog = false;
            },
        }
    }
</script>

<style scoped>

</style>
<!--
========================リファクタリング========================
・ユーザーの配下にフォルダーを入れたいが、手間が大きいので後回し。
今はuserとphotoで直だが、今後はuser-folder-photoにしたい。
Photoの項目をPhotoFolderにしたい。




-->