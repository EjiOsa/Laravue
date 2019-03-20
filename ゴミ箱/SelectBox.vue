<template>
    <div id="select">
        <v-app id="inspire">
            <v-container>
                <v-layout wrap justify-space-between>

                    <v-flex xs6 sm3 d-flex>
                        <v-select
                                :items="events"
                                box
                                label="select Event"
                                v-model="selected"
                                @change="get_event"
                        ></v-select>
                    </v-flex>

                </v-layout>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: "SelectBox",
        props: {
            events: {}
        },
        data(){
            return{
                selected: '',
            }
        },
        methods:{
          get_event(){
              this.$parent.add_event = this.selected;
          }
        }
    }
</script>

<style scoped>

</style>