<template>
    <div>
        <main>
            <div class="base">
                <router-link  to="/PhotoList" class="btn btn-info">
                    <a>
                        PhotoList
                    </a>
                </router-link>
                <router-link  to="/PhotoDetail" class="btn btn-info">
                    <a>
                        PhotoDetail
                    </a>
                </router-link>
            </div>
            <div class="container">
                <router-view />
            </div>
        </main>
    </div>
</template>

<script>
    export default {
        name: "user_root",
        data(){
            return {
                show: true
            }
        },
    }
</script>

<style scoped>

</style>