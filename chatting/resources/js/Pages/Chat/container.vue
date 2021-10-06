<template>
    <app-layout>
        <template #header>
            <chat-room-selection
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomChanged="setRoom($event)"
            />
        </template>

        <message-container :messages="messages">
        </message-container>
        <input-message :room="currentRoom" v-on:messageSent="getMessages(currentRoom.id)">

        </input-message>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';

export default {
    name: "container",
    components : {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
    },
    data() {
        return {
            chatRooms : [],
            currentRoom : {},
            messages : [],

        }
    },

    methods : {
        getRooms() {
            axios.get('/chat/rooms')
                .then(response => {
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
            }).catch(error => {
                console.log(error);
            })
        },
        setRoom(room) {
            this.currentRoom = room;
            this.getMessages(room.id);
        },
        getMessages(roomId) {
            axios.get('/chat/room/' + roomId + '/messages')
                .then(response => {
                    this.messages = response.data;
                }).catch(error => {
                    console.log(error);
            })
        },
    },

    created() {
        this.getRooms();
    }
}
</script>

<style scoped>

</style>
