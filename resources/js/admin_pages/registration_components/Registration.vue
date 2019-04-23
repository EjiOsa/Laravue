<template>
    <v-container grid-list-md>
        <v-form ref="form">
            <div>
                <h2 class="panel-title">ユーザーの{{editData.edit === true ? "編集・削除" : "追加"}}</h2>
            </div>
            <v-text-field
                    v-model="editData.first_name"
                    v-validate="'required|max:50'"
                    :counter="10"
                    :error-messages="errors.collect('名前')"
                    label="Users First Name"
                    data-vv-name="名前"
                    required
            ></v-text-field>

            <v-text-field
                    v-model="editData.family_name"
                    v-validate="'required|max:50'"
                    :counter="10"
                    :error-messages="errors.collect('苗字')"
                    label="Users Family Name"
                    data-vv-name="苗字"
                    required
            ></v-text-field>

            <v-text-field
                    v-model="editData.age"
                    v-validate="'max:5|numeric'"
                    :counter="5"
                    :error-messages="errors.collect('年齢')"
                    label="Users Age"
                    data-vv-name="年齢"
            ></v-text-field>

            <v-text-field
                    v-model="editData.email"
                    v-validate="'required|email'"
                    :error-messages="errors.collect('Email')"
                    label="Users Email"
                    data-vv-name="Email"
                    required
            ></v-text-field>

            <!--<v-select-->
                    <!--v-model="select"-->
                    <!--v-validate="'required'"-->
                    <!--:items="userCategory"-->
                    <!--:error-messages="errors.collect('Category')"-->
                    <!--label="User Category"-->
                    <!--data-vv-name="Category"-->
                    <!--required-->
            <!--&gt;</v-select>-->

            <!--<v-checkbox-->
                    <!--v-model="checkbox"-->
                    <!--v-validate="'required'"-->
                    <!--:error-messages="errors.collect('checkbox')"-->
                    <!--value="1"-->
                    <!--label="Option"-->
                    <!--data-vv-name="checkbox"-->
                    <!--type="checkbox"-->
                    <!--required-->
            <!--&gt;</v-checkbox>-->
        </v-form>
            <v-layout row>
                <v-flex xs1 offset-xs8>
                    <v-btn @click="clear" >clear</v-btn>
                </v-flex>
<!--            </v-layout>-->
<!--            <v-layout row>-->
                <v-flex xs1 offset-xs4>
                    <v-btn @click="addUser" v-show="editData.edit === true">edit</v-btn>
                </v-flex>
                <v-flex xs1 offset-xs3>
                    <v-btn @click="delUser" v-show="editData.edit === true">delete</v-btn>
                </v-flex>
<!--            </v-layout>-->
<!--            <v-layout row>-->
                <v-flex xs1 offset-xs8>
                    <v-btn @click="addUser" v-show="editData.edit === false">add</v-btn>
                </v-flex>
            </v-layout>
    </v-container>
    <!--<div class="split-box right-box">-->
        <!--<div class="contents">-->
            <!--<form>-->
                <!--<div>-->
                    <!--<h2 class="panel-title">ユーザの{{editData.edit === true ? "編集・削除" : "追加"}}</h2>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col2 control-label">FirstName</label>-->
                    <!--<p>-->
                        <!--<input name="userFirstName"-->
                               <!--v-model="editData.first_name"-->
                               <!--data-vv-as="名前"-->
                               <!--v-validate="'required|max:50'"-->
                               <!--type="text"-->
                               <!--:class="{'input': true,-->
                               <!--'first-name-error': errors.has('userFirstName') }"-->
                               <!--placeholder="Users First Name"-->
                        <!--&gt;-->
                        <!--<i v-show="errors.has('userFirstName')"></i>-->
                        <!--<span v-show="errors.has('userFirstName')">{{ errors.first('userFirstName') }}</span>-->
                    <!--</p>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col2 control-label">FamilyName</label>-->
                    <!--<p>-->
                        <!--<input name="userFamilyName"-->
                               <!--v-model="editData.family_name"-->
                               <!--v-validate="'required|max:50'"-->
                               <!--data-vv-as="苗字"-->
                               <!--type="text"-->
                               <!--placeholder="Users Family Name"-->
                               <!--:class="{'input': true,-->
                               <!--'family-name-error': errors.has('userFamilyName') }"-->
                        <!--&gt;-->
                        <!--<i v-show="errors.has('userFamilyName')"></i>-->
                        <!--<span v-show="errors.has('userFamilyName')">{{ errors.first('userFamilyName') }}</span>-->
                    <!--</p>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col2 control-label">Age</label>-->
                    <!--<p>-->
                        <!--<input name="userAge"-->
                               <!--v-model="editData.age"-->
                               <!--data-vv-as="年齢"-->
                               <!--v-validate="'required|max:11|numeric'"-->
                               <!--type="text"-->
                               <!--placeholder="Users Age"-->
                               <!--:class="{'input': true,-->
                               <!--'age-error': errors.has('userAge') }"-->
                        <!--&gt;-->
                        <!--<i v-show="errors.has('userAge')"></i>-->
                        <!--<span v-show="errors.has('userAge')">{{ errors.first('userAge') }}</span>-->
                    <!--</p>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col2 control-label">Email</label>-->
                    <!--<p>-->
                        <!--<input name="userEmail"-->
                               <!--v-model="editData.email"-->
                               <!--v-validate="'required|email'"-->
                               <!--data-vv-as="メールアドレス"-->
                               <!--type="text"-->
                               <!--placeholder="Users Email"-->
                               <!--:class="{'input': true,-->
                               <!--'mail-error': errors.has('userEmail') }"-->
                        <!--&gt;-->
                        <!--<i v-show="errors.has('userEmail')"></i>-->
                        <!--<span v-show="errors.has('userEmail')">{{ errors.first('userEmail') }}</span>-->
                    <!--</p>-->
                <!--</div>-->
                <!--&lt;!&ndash;<div class="form-group">&ndash;&gt;-->
                    <!--&lt;!&ndash;<label class="col2 control-label">Password</label>&ndash;&gt;-->
                    <!--&lt;!&ndash;<p>&ndash;&gt;-->
                        <!--&lt;!&ndash;<input name="userPass"&ndash;&gt;-->
                               <!--&lt;!&ndash;v-model="editData.password"&ndash;&gt;-->
                               <!--&lt;!&ndash;v-validate="'required'"&ndash;&gt;-->
                               <!--&lt;!&ndash;data-vv-as="発行用パスワード"&ndash;&gt;-->
                               <!--&lt;!&ndash;type="text"&ndash;&gt;-->
                               <!--&lt;!&ndash;placeholder="Users Pass"&ndash;&gt;-->
                               <!--&lt;!&ndash;:class="{'input': true,&ndash;&gt;-->
                               <!--&lt;!&ndash;'pass-error': errors.has('userPass') }"&ndash;&gt;-->
                        <!--&lt;!&ndash;&gt;&ndash;&gt;-->
                        <!--&lt;!&ndash;<i v-show="errors.has('userPass')"></i>&ndash;&gt;-->
                        <!--&lt;!&ndash;<span v-show="errors.has('userPass')">{{ errors.first('userPass') }}</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;</p>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->
                <!--<div class="panel-footer text-right">-->
                    <!--<button class="del-user" @click.prevent="delUser" v-if="editData.edit === true">削除</button>-->
                        <!--&lt;!&ndash;<button class="btn btn-primary v-fade" type="submit" v-if="isValid">{{editUserId > -1 ? "更新" : "追加"}}</button>&ndash;&gt;-->
                    <!--<button class="add-user" @click.prevent="addUser" v-if="errors">{{editData.edit === true ? "更新" : "追加"}}</button>-->
                        <!--&lt;!&ndash;<button class="add-user" @click.prevent="delText" v-if="errors">削除</button>&ndash;&gt;-->
                <!--</div>-->
            <!--</form>-->
        <!--</div>-->
    <!--</div>-->
</template>

<script>
export default {
    name: 'userRegistration',
    props: ['editData'],
    computed:{
    },
    data(){
        return{
            userCategory:[
                'private',
                'group'
            ]
        }
    },
    methods: {
        addUser () { // addUser: function (){ これと同義
            this.$validator.validateAll().then((result) => {
                if (result) {
                    // 以下、エラーがなかった時の処理
                    this.$emit('user-addition');
                    this.$forceUpdate();// dataの値をDOMへ再評価させ表示させる
                    // this.clear();
                }
            });
        },
        clear (){
            if(this.editData.edit === true){
                this.editData = {
                    first_name: '',
                    family_name: '',
                    age: '',
                    email: '',
                    edit: true
                };
            }else{
                this.editData = {
                    first_name: '',
                    family_name: '',
                    age: '',
                    email: '',
                    edit: false
                };
            }
        },
        delUser () {
            this.$emit('user-delete');
            this.$forceUpdate();
        },
    }
};
</script>

<style scoped lang="scss">
    @import '../../../sass/app';

    /*.split-box{*/
        /*position:fixed;*/
        /*z-index: 10;*/
        /*height:100%;*/
        /*padding:1em;*/
        /*top: 50px;*/
    /*}*/
    /*.right-box {*/
        /*box-sizing: border-box;*/
        /*margin-top: 115px;*/
        /*padding: 0 3%;*/
        /*width:70%;*/
        /*right:0;*/
        /*overflow-y:scroll;*/
    /*}*/

</style>

<!--
==================リファクタリング========================
・新規追加と編集時のボタン上下のマージンが違う。


-->
