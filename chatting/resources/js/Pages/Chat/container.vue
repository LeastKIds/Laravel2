<template>
    <app-layout>
        <template #header>
            <chat-room-selection
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomChanged="setRoom($event)"
            />
        </template>

        <styled-message-container :messages="messages" />
<!--        <message-container :messages="messages">-->
<!--        </message-container>-->
        <input-message :room="currentRoom" v-on:messageSent="getMessages">

        </input-message>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';
import StyledMessageContainer from './styledMessageContainer.vue';

export default {
    name: "container",
    components : {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
        StyledMessageContainer,
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
            // if(this.currentRoom != null && this.currentRoom.id != room.id) {
            //     this.disconnect(this.currentRoom);
            // }
            this.currentRoom = room;
            // this.connect();
            // this.getMessages(room.id);
        },
        getMessages() {
            axios.get('/chat/room/' + this.currentRoom.id + '/messages')
                .then(response => {
                    this.messages = response.data;
                }).catch(error => {
                    console.log(error);
            })
        },
        disconnect(room) {
            window.Echo.leave('chat.'+room.id);
        },
        connect() {
        //    방이 변경되었을 때, 이 메소드가 호출되니
        //    이 방의 메세지를 불러와 디스플레이 해준다.
        //    변경된 방은 currentRoom에 정보가 있음
            this.getMessages();
            const vm = this;
            window.Echo.private('chat.'+this.currentRoom.id)
                .listen('.message.new', e=> {
                    vm.getMessages();
            });
        }
    },
    watch: {
        currentRoom(val, oldVal) {
            if (oldVal.id) {
                this.disconnect(oldVal);
            }
            this.connect();
        }
    },

    created() {
        this.getRooms();
    },
}
</script>

<style scoped>

</style>
