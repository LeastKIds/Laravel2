<template>
    <app-layout>
        <form @submit.prevent="submit">
            <input type="text" v-model="form.name" />
            <input type="file" @input="form.avatar = $event.target.files[0]" />
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
            </progress>
            <button type="submit">Submit</button>
        </form>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
    name: "test",
    components : {
        AppLayout,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                avatar: null,
            }),
        }
    },
    methods : {
        submit() {
            this.form.post('/test')
        },
    }
    ,
    mounted() {

    }
}
</script>

<style scoped>

</style>
