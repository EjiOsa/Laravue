 <template>
     <v-container fluid grid-list-md>
         <v-data-iterator
                 :items="users"
                 :rows-per-page-items="rowsPerPageItems"
                 :pagination.sync="pagination"
                 content-tag="v-layout"
                 row
                 wrap
         >
             <template v-slot:item="props">
                 <v-flex
                    xs12
                    sm6
                    md4
                    lg3
                 >
                     <v-card
                             @dblclick=dialogOpen(props.item)
                     >
                         <v-card-title><h4>{{props.item.family_name}} {{props.item.first_name}}</h4></v-card-title>
                         <v-divider></v-divider>
                         <v-list dense>
                             <v-list-tile>
                                 <v-list-tile-content>Email:</v-list-tile-content>
                                 <v-list-tile-content class="align-end">{{props.item.email}}</v-list-tile-content>
                             </v-list-tile>
                             <v-list-tile>
                                 <v-list-tile-content>Photos:</v-list-tile-content>
                                 <v-list-tile-content class="align-end">{{props.item.photo_count}}</v-list-tile-content>
                             </v-list-tile>
                             <!--<v-list-tile>-->
                                 <!--<v-list-tile-content>Age:</v-list-tile-content>-->
                                 <!--<v-list-tile-content class="align-end">{{props.item.age}}</v-list-tile-content>-->
                             <!--</v-list-tile>-->

                                <!--<p v-show="props.item.edit">編集有効</p>-->
                                <!--<button class="edit-btn" @click.prevent="userEdit">編集</button>-->
                                <!--<button class="edit-btn" @click.prevent="userEdit">{{props.item.edit === true ? "編集中止" : "編集・削除"}}</button>-->
                             <v-list-tile>
                                 <v-list-tile-content class="align-end">
                                     <v-btn color="blue-grey lighten-4" small @click.prevent="userEdit(props.item.id)" >
                                         <v-icon dark>edit</v-icon>
                                     </v-btn>
                                 </v-list-tile-content>
                             </v-list-tile>
                         </v-list>
                     </v-card>
                 </v-flex>
             </template>
         </v-data-iterator>
     </v-container>
</template>
 <!--<template>-->
    <!--<li class="split-box side-bar">-->
                <!--<dt>{{userData.id}}</dt>-->
                <!--<dt>{{userData.first_name}}</dt>-->
                <!--<dt>{{userData.family_name}}</dt>-->
                <!--<dt>{{userData.age}}</dt>-->
                <!--<dt>{{userData.email}}</dt>-->
                <!--&lt;!&ndash;<dt>{{userData.edit}}</dt>&ndash;&gt;-->
        <!--<p v-show="userData.edit">編集有効</p>-->
        <!--&lt;!&ndash;<button class="edit-btn" @click.prevent="userEdit">編集</button>&ndash;&gt;-->
        <!--<button class="edit-btn" @click.prevent="userEdit">{{userData.edit === true ? "編集中止" : "編集・削除"}}</button>-->
        <!--&lt;!&ndash;<button class="edit-btn" @click.prevent="dataEdit; edit = !edit">編集</button>参考に残す&ndash;&gt;-->
    <!--</li>-->
<!--</template>-->

<script>
export default {
    name: 'UserIterator',
    props: {
        users: {
            type: Object
        },
    },
    methods: {
        userEdit (id) {
            this.$emit('user-edit', id);
        },
        dialogOpen(item){
            this.$emit('user-dialog-open', item)
        }
    },
    computed:{
    },
    data(){
        return{
            editId:'',
            rowsPerPageItems: [8, 16, 32],
            pagination: {
                rowsPerPage: 8
            },
        }
    }
};
</script>

<style scoped lang="scss">
    @import '../../../sass/app';

    /*.split-box{*/
        /*!*position:absolute;*!*/
        /*z-index: 0;*/
        /*padding:1em;*/
        /*top: 50px;*/
    /*}*/
    /*.side-bar {*/
        /*width:30%;*/
        /*left:0;*/
        /*overflow-y:scroll;*/
    /*}*/
</style>
 <!--
==================リファクタリング========================
・カードの表示内容のカテゴリーをどうするか。
・カードの内容もグループを使えるようにするなら、familyとfirstをnameに統一する。
 -->