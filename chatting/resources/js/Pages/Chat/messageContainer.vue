<template>
    <div class="h-96 w-full">
        <div class="p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="msg in messages" :key="msg.id">
                <message-item :message="msg" />
<!--                {{msg.message}}-->
            </div>
        </div>

    </div>

</template>

<script>
import MessageItem from './messageItem.vue';

export default {
    name: "messageContainer",
    props:['messages', 'loginUserId'],
    components: {
        MessageItem,
    }
}
</script>

<style scoped>

</style>
