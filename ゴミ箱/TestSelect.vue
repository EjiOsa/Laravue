<template>
    <div id="select">
        <v-app id="inspire">
            <v-container fluid grid-list-xl>
                <v-layout wrap align-center>
                    <v-flex xs12 sm6 d-flex>
                        <v-select
                                :items="items"
                                label="Standard"
                                v-model="selected"
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm6 d-flex>
                        <v-select
                                :items="items"
                                box
                                label="Box style"
                                v-model="selected2"
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm6 d-flex>
                        <v-select
                                :items="items"
                                label="Outline style"
                                outline
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm6 d-flex>
                        <v-select
                                :items="items"
                                label="Solo field"
                                solo
                        ></v-select>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: "TestSelect",
        data() {
            return {
                items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
                selected: '',
                selected2: ''
            }
        },
    }
</script>

<style scoped>

</style>