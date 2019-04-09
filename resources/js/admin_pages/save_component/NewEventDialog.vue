 <template>
        <v-layout row justify-center>
            <v-dialog v-model="eventNameDialog" persistent max-width="400px">
                <v-card>
                    <v-card-title>
                        <span class="headline">New Event</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field
                                            v-model="newEvent.name"
                                            clearable
                                            v-validate="'required|is_not:{{this.eventNameList}}'"
                                            :error-messages="errors.collect('イベント名')"
                                            label="New Event Name*"
                                            data-vv-name="イベント名"
                                            hint="新しいイベント名を入力してください"
                                            persistent-hint
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="formCancel">Cancel</v-btn>
                        <v-btn color="blue darken-1" flat @click="formSave">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
    </template>

<script>
    export default {
        name: "NewEventDialog",
        props:{
            newEvent:{
                type: Object
            },
            eventNameList:{//||is_not:eventNameListとしたい。
                type: Array
            }
        },
        data(){
            return{
                eventNameDialog: false,
            }
        },
        methods:{
            formCancel(){
                this.eventNameDialog = false;
                this.$validator.reset()
            },
            formSave(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.eventNameDialog = false;
                        this.$emit('event-addition');
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>
 <!--
 ====================リファクタリング====================
 ・登録されている名前はis_notでバリデーションエラーにしたい。
 名前のリストは手に入れたけど、その指定方法がわからない。



 -->