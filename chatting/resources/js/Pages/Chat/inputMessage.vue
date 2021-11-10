<template>
    <div>
        <input type="text" v-model="message" @keyup.enter="sendMessage">
        <button @click="sendMessage">Send</button>
    </div>
</template>

<script>
export default {
    name: "inputMessage",
    props: ['room'],
    data() {
        return {
            message : ''
        }
    },
    methods: {
        sendMessage() {
            if(this.message == '') return;
            axios.post('/chat/'+this.room.id+'/message', {message : this.message})
                .then(response => {
                    console.log(response.status);
                    this.message = '';
                    this.$emit('messageSent');
                }).catch(error => {
                    console.log(error);
            })
        },

    }
}
</script>

<style scoped>

</style>
