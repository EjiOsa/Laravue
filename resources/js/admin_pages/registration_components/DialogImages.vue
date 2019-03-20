<template>
    <v-layout>
        <v-flex xs12 sm12>
            <v-container grid-list-sm fluid>
                <v-layout row wrap>
                    <v-flex
                            v-for="image in userImages"
                            :key="image.name"
                            xs4
                            d-flex
                    >
                        <v-card flat tile class="d-flex">
                            <v-img
                                    :src="image.photo"
                                    aspect-ratio="1"
                                    class="grey lighten-2"
                            >
                            <!--<v-img-->
                                    <!--:src="`https://picsum.photos/500/300?image=${n * 5 + 10}`"-->
                                    <!--:lazy-src="`https://picsum.photos/10/6?image=${n * 5 + 10}`"-->
                                    <!--aspect-ratio="1"-->
                                    <!--class="grey lighten-2"-->
                            <!--&gt;-->
                                <template v-slot:placeholder>
                                    <v-layout
                                            fill-height
                                            align-center
                                            justify-center
                                            ma-0
                                    >
                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-layout>
                                </template>
                            </v-img>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "DialogImages",
        props:{
            userImages: {
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>