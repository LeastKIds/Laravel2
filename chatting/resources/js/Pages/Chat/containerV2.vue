<template>
    <app-layout>
        <template #header>
            <chat-room-selection
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomChanged="setRoom($event)"
            />
        </template>

        <div class="py-12">
            <div class="flex flex-col justify-between flex-1 h-screen p:2 sm:p-6">
                <div v-if="messages" class="p-2 flex flex-col-reverse overflow-scroll">
                    <div v-for="msg in messages.data" :key="msg.id" >
                        <styled-message-item :message="msg" />
                    </div>
                </div>
            </div>
        </div>
        <input-message :room="currentRoom" v-on:messageSent="getMessages">

        </input-message>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
// import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';
// import StyledMessageContainer from './styledMessageContainer.vue';
import StyledMessageItem from './styledMessageItem';

export default {
    name: "container",
    components : {
        AppLayout,
        // MessageContainer,
        InputMessage,
        ChatRoomSelection,
        // StyledMessageContainer,
        StyledMessageItem,
    },
    data() {
        return {
            chatRooms : [],
            currentRoom : {},
            messages : null,

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
                    // vm.getMessages();
                    vm.messages.data = [e.msg, ...vm.messages.data];
                });
        },
        getMoreMessages() {
            console.log(this.messages.current_page);
            if (this.messages.current_page === this.messages.last_page) {
                // alert('No more message')
                return;
            }
            axios.get(this.messages.next_page_url)
                .then(response => {
                    // this.messages = {...response.data, 'data' : [...this.messages.data, ...response.data.data]}
                    const chatMsg = this.messages.data;
                    console.log(chatMsg)
                    this.messages = response.data;
                    this.messages.data = [...chatMsg, ...this.messages.data ]

                }).catch(error => {
                    console.log(error);
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
    mounted() {
        window.addEventListener('scroll', debounce((e) => {
            // console.log('scoll')
            // console.log('offsetHeight : ' + document.documentElement.offsetHeight)
            // console.log('scrollTop : ' + document.documentElement.scrollTop)
            // console.log('innerHeight : ' + window.innerHeight)
            if (document.documentElement.scrollTop < 10) {
                this.getMoreMessages();
            }
        }, 100))
    }
}
</script>

<style scoped>

</style>
