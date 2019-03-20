<template>
    <v-layout row justify-center>
        <v-dialog v-model="photoDialog" max-width="900px">
            <v-card>
                <v-card-title>
                    <span class="headline">Photo Detail</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12>

                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="photoDialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        name: "PhotoDetailDialog",
        data(){
            return{
                photoDialog: false,
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>