<template>
    <div class="grid grid-cols-2">
        <div class="font-bold text-xl">
            {{ currentRoom.name }} Chat Room
        </div>

        <select
            v-model="currentRoom"
            class="float-right"
            @change="$emit('roomChanged', currentRoom)"
        >
            <option v-for="(room, index) in rooms" :key="index"
                    :value="room"
                    selected="currentRoom.name==room.name"
            >
                {{ room.name }}
            </option>
        </select>
    </div>

</template>

<script>
export default {
    name: "chatRoomSelection",
    props: ['rooms','currentRoom'],
    data() {
        return {

        }
    },
    created() {
        // this.selected = this.currentRoom;
    }
}
</script>

<style scoped>

</style>
