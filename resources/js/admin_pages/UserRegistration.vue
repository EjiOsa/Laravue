<template>
    <div>
        <div class="head">
            <h2>User Registration</h2>
            <v-btn color="blue-grey lighten-4" @click="openDrawer">New User</v-btn>
        </div>
        <v-navigation-drawer
                right
                temporary
                v-model="right"
                fixed
        >
            <registration
                    :edit-data="editUser"
                    @user-addition = "userAddition"
                    @user-delete = "userDelete"
                    ref="registration"
            ></registration>
        </v-navigation-drawer>
        <user-iterator
                :users="users"
                @user-edit="userEdit"
                @user-dialog-open="userDialogOpen"
        ></user-iterator>
        <user-detail-dialog
                :detail-dialog="detailDialog"
                :detail-data ="detailDialogData"
                :token-data="tokenData"
                :user-images="userImages"
                ref="userDetail"
        ></user-detail-dialog>

        <!--<registration-->
        <!--:edit-data="editUser"-->
        <!--@add = "add"-->
        <!--@del = "del"-->
        <!--@up = "update"-->
        <!--&gt;</registration>-->
        <!--<ul class="side-bar-list">-->
                <!--<side-bar-->
                        <!--v-for="user in users"-->
                        <!--:key="user.id"-->
                        <!--:userData="user"-->
                        <!--@userEdit="userEdit"-->
                <!--&gt;</side-bar>-->
        <!--</ul>-->
            <!--</v-data-iterator>-->
        <!--</v-container>-->
    </div>
</template>

<script>
    import Registration from './registration_components/Registration';
    import UserIterator from './registration_components/UserIterator';
    import UserDetailDialog from './registration_components/UserDetailDialog';

    const UsersApiUrl = 'http://localhost/photo_share/laravue_test1/public/api/users';
    const UsersAxios = require('axios').create({//axiosにapi_tokenを埋め込んでいる。
        baseURL: UsersApiUrl,
        // responseType: 'json'//jsonがdefaultsのためコメントアウト
    });
    UsersAxios.defaults.headers['Accept'] =  'application/json';

    // const params = new URLSearchParams();

    export default {
    name: 'UserRegistration',
    props:{
        tokenData: {
            type: String,
            // required: true
        }
    },
    components: {
        Registration,
        UserIterator,
        UserDetailDialog
    },
    computed:{
        tokenNo() {
        return this.tokenData
        }
    },
    data () {
        return {
            users: [],
            editUser: {
                first_name: '',
                family_name: '',
                age: '',
                email: '',
                password: '',
                edit: false
            },
            right: null,
            detailDialog:　false,//表示OnOff
            detailDialogData:　{},
            userImages: {},
        };
    },
    // mounted () {
    created(){
        UsersAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;//ここでデフォルトを変更したら全てに反映されてもいいと思うけど違うらしい。下のaxiosにもつけないとエラーになる。
        UsersAxios.get()
            .then(response => (this.users = response.data));
    },
    methods: {
        // edit method
        clearEdit () {
            this.editUser = {
                first_name: '',
                family_name: '',
                age:'',
                email: '',
                password: '',
                edit: false
            };
        },
        // SideBar method
        userEdit (selectUserID) { // ユーザー編集のON//とOFF
            if (confirm('ユーザー情報を編集しますか？')) {
                let selectEditUser = this.users.findIndex(({id}) => id === selectUserID);// IDから編集を選択されたユーザー取得
                this.releaseEdit(selectEditUser);
                this.users[selectEditUser].edit = true;//!this.users[selectEditUser].edit;//コメントアウトは前の設定
                this.setCurrentUser();
                this.right = true;//!this.right;//右側の編集画面の表示
                this.detailDialog = false;//closeボタンで閉じてないとfalseになってなくて、同じユーザーで開けようとした時に二つ開いてしまう。
                this.$forceUpdate();
            }
        },
        releaseEdit (userIndex) { // 選択したユーザー以外が編集中だった場合に解除
            let editTrueIndex = this.users.findIndex(({ edit }) => edit === true);// 編集中のユーザーインデックスを取得
            if (editTrueIndex > -1) { // indexで取得のためindexが有効かチェック
                if (this.users[editTrueIndex].edit !== this.users[userIndex].edit) { // 編集中のユーザーと選択したユーザーが違う場合に削除発火
                    this.users[editTrueIndex].edit = false;
                }
            }
        },
        setCurrentUser () {
            let editTrueIndex = this.users.findIndex(({ edit }) => edit === true);
            if (editTrueIndex > -1) {//編集ONになった際に右の編集画面に反映させるメソッド
                // this.editUser = this.users[editTrueIndex];// *1
                //JSはオブジェクト型に関しては参照渡しになっている。
                //*1ではイテレーターのカードも変更されてしまう。*2にすることで値渡しになっていて、編集画面のみ変更される。
                this.editUser = Object.assign({}, this.users[editTrueIndex]);// *2
            // } else {//編集OFFの操作
            //     this.refresh();//編集を更新しない場合はデータベースを再取得
            //     this.clearEdit();//右側の記入欄をクリア
            }
        },
        //Api method
        async userUpdate (data) {//ユーザー情報の更新
            UsersAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UsersAxios.put(UsersApiUrl+'/'+data.id, data)
                .then(
                    alert('ユーザー情報の更新に成功しました')
                )
                .catch(function (err) {
                    alert(err)
                });
            this.refresh()
        },
        async userRegistration () {//Userの追加
            UsersAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UsersAxios.post('', this.editUser)
                .then(
                    alert('user add ok')
                )
                .catch(function (err) {
                    alert(err);
                });
            this.refresh()//thenの中に書いて不安定になってたけど、ここにして安定した。
        },
        async softDelete (id) {//Userの論理削除、Deleted_atにTimeStamp入力
            UsersAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UsersAxios.delete(UsersApiUrl+'/'+id)
                .then(
                    alert('user softDeleted ok')
                )
                .catch(function (err) {
                    alert(err)
                });
            this.refresh()
        },
        refresh (){//Api処理後の再表示
            UsersAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            UsersAxios.get()
                .then(response => (
                    this.users = response.data
                ))
                .catch(err => (
                    alert(err)
                ));
        },
        remakeData(base, data){//data:image/jpeg;base64がない状態で送られてくるので、ここで追加。
            for(let i = 0, len = base.length; i < len ; i++){
                base[i].photo = 'data:image/jpeg;base64,'+base[i].photo;//リファクタリング
            }
            data = base;
        },
        async getImages(){
            const UserPhotoUrl = 'http://localhost/photo_share/laravue_test1/public/api/photo_user_relation/'+ this.detailDialogData.id;
            const UserPhotoAxios = require('axios').create({
                baseURL: UserPhotoUrl,
            });
            UserPhotoAxios.defaults.headers['Authorization'] = 'Bearer '+this.tokenNo;
            await UserPhotoAxios.get()
                .then(response => (this.userImages = response.data));
            this.remakeData(this.userImages, this.userImages);
        },
        // Registration method
        userAddition () {
            if (this.users.find(editId => editId.id === this.editUser.id)) { //users内にeditUserのidが存在する＝＞更新の場合
                if (confirm('ユーザー情報を更新しますか？')) {
                    //↑ var result = confirm('ユーザー情報を更新しますか？')をそのまま代入している。
                    let editTrueIndex = this.users.findIndex(({edit}) => edit === true);// 編集中のインデックス取得
                    this.users[editTrueIndex].edit = false;//!this.users[editTrueIndex].edit; // 編集ボタンを解除
                    this.userUpdate(this.editUser);//users[editTrueIndex]);
                    this.clearEdit();
                    this.right = false;
                }
            } else { // users内にeditUserのidが存在しない＝＞追加の場合
                if (confirm('ユーザーを追加しますか？')) {
                    this.userRegistration();
                    this.clearEdit();
                    this.right = false;
                 }
            }
        },
        userDelete () {
            if (confirm('ユーザーを削除しますか？')) {//user削除
                let editTrueIndex = this.users.findIndex(({edit}) => edit === true);
                this.softDelete(this.users[editTrueIndex].id);
                this.clearEdit();
                this.right = false;
                this.refresh();
            }
        },
        openDrawer(){//右側の登録画面
            this.clearEdit();
            this.$refs.registration.$validator.reset();
            this.detailDialog = false;
            this.right = true;
        },
        userDialogOpen(item){//UserDetailDialogの表示
            this.userImages = {};
            this.detailDialogData = item;
            this.getImages();
            this.detailDialog = false;//closeボタンで閉じてないとfalseになってなくて、同じユーザーで開けようとした時にエラーになる。
            this.detailDialog = true;
        }
    }
};
</script>

<style scoped lang="scss">

</style>
