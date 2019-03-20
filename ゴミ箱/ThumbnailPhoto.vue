<template>
    <div class="col-md-4"
         draggable="true"
         @dragstart="dragStart">
        <figure v-if="image">
            <a href="">
                <img :src="image.photo" alt="" class="img-thumbnail"/>
            </a>
        </figure>
    </div>
</template>

<script>
    export default {
        name: "ThumbnailPhoto",
        props: {
            image: {
                type: Object,
                required: true
            }
        },
        methods: {
            dragStart: function(event) {
                event.dataTransfer.setData("text", this.image.name);
            },
        }
    }
</script>

<style scoped>

</style>