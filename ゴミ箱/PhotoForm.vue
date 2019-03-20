<template>
    <div
            class="drop"
            v-show="value"
            v-bind:class="{ 'dragActive':isActive, 'dragPhoto':isPhoto}"

            @dragover.prevent="dragOver"
            @dragleave.prevent="dragLeave"
            @drop.prevent="onFileChange($event)">

        <h2 class="title">select photos</h2>

        <h5 class="text-center" v-show="isPhoto && !isActive">画像はこちらに</h5>
        <h5 class="text-center" v-show="!isActive && !isPhoto">点線内にドラッグで選択可能</h5>
        <h5 class="text-center" v-show="isActive && !isPhoto">画像を登録</h5>

        <form>
            <!--<input type="file" multiple accept="image/*" name="thumbnail[]" @change="onFileChange($event)">-->
            <label id="input_custom" class="btn btn-light">
                画像を選択
                <input type="file" multiple accept="image/*" name="thumbnail[]" @change="onFileChange($event)" style="display:none;">
            </label>
        </form>
    </div>
</template>

<script>
    export default {
        name: "PhotoForm",
        props:{
            value: {// v-model使用時のデフォルトの変数名
                type: Boolean,
                required: true
            },
        },
        data(){
            return {
                isActive: false,
                isPhoto: false,
            }
        },
        methods: {
            dragStart(){//ドラッグ開始時に変化させたかったけど、無理そう。もう少し置いておく。
                this.isActive = false;
                this.isPhoto = true;
            },
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
                let files = e.target.files || e.dataTransfer.files;//inputのファイル（画像）はfileListって名前のオブジェクトで渡される。
                //targetはinputタグから取得の画像、dataTransferはdropからの画像。
                if(files.length) {
                    for (var i = 0; i < files.length; i++) {//fileListを渡した先の関数で展開しようとすると、非同期のために（？）展開が先に走って画像が出ない。
                        this.createImage(files[i]);//先にこっちで展開して、関数はデータの処理に専念させる。
                    }
                }
            },
            // 取得した画像を描画
            createImage(file) {
                let reader = new FileReader();
                let obj = {};
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    obj.photo = e.target.result;
                    obj.uploadFile = file;
                    obj.name = file.name;
                    this.$parent.prepare_images.push(obj);
                };
            },
        },
    }
</script>

<style scoped>
    .drop{
        width: 100%;
        padding: 0.5em 1em;
        margin: 2em 0;
        background: rgba(205, 240, 255, 0.55);
        border: dashed 2px #05144b;/*点線*/
        border-radius: 10px;
    }
    #input_custom {
        padding: 6px;
        border-radius: 4px;
    }
    .dragActive{
        background: rgba(176, 188, 214, 0.85);
    }
    .dragPhoto{
        background:  rgba( 104, 20, 214, 0.85 );
    }
</style>