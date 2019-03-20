<template>
    <div>
        <test-select></test-select>
        <h2>User Detail</h2>
        <p>ユーザー詳細ページ
            <br>メール送信の送信ボタンを配置（送信内容は固定にして、アップしたことを伝えるのみ）
            <br>ユーザーに紐づいたフォルダの管理。複数のイベントの際には複数のフォルダが出てくる。</p>
    </div>
</template>

<script>
    import TestSelect from './TestSelect'
    export default {
        name: "UserDetail",
        components:{
            TestSelect
        }
    }
</script>

<style scoped>

</style>