<template>
    <li
            class="split-box user-list text-center"
            v-bind:class="{ 'dragActive':isActive, 'dragPhoto':isPhoto}"

            @dragover.prevent="dragOver"
            @dragleave.prevent="dragLeave"
            @drop.prevent="onFileChange($event)"
            @dblclick="dbTest(folderData.id)"
    >
        <dt>{{folderData.name}}</dt>
        <dt>{{folderData.first_name}}</dt>
        <dt>{{folderData.family_name}}</dt>
        <h5 class="text-center" v-show="isActive && !isPhoto">画像を登録</h5>
     </li>
</template>

<script>
    export default {
        name: "PhotoFolder",
        props: {
            folderData: {
                type: Object
            }
        },
        data(){
            return {
                isActive: false,
                isPhoto: false,
            }
        },
        methods: {
            dragOver(){
                this.isActive = true;
                this.isPhoto = false;
            },
            dragLeave(){
                this.isActive = false;
                this.isPhoto = false;
            },
            onFileChange(e) {
                this.dragLeave();
                console.log(e.dataTransfer.getData('text'));
            },
            dbTest(id){
                this.$parent.showFolder = false;
                this.$emit('image',id);
            },
        },
    }
</script>

<style scoped lang="scss">
    @import '../resources/sass/app';

    .split-box{
        /*position:absolute;*/
        z-index: 0;
        padding:1em;
        top: 50px;
        width: 100px;
        background: rgba(205, 175, 206, 0.55);
        border: dashed 2px #05144b;/*点線*/
        border-radius: 10px;
    }
    .user-list {
        /*width:30%;*/
        left:0;
        overflow-y:scroll;
    }
    .dragActive{
        background: rgba(176, 188, 214, 0.85);
    }
    .dragPhoto{
        background:  rgba( 104, 20, 214, 0.85 );
    }
</style>