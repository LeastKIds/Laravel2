<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-row items-start">
                <div class="flex-shrink-0 mr-3 px-40" v-if="$page.props.jetstream.managesProfilePhotos">
                    <img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" class="rounded-full h-20 w-20 object-cover">
                </div>
                <div class="flex-col justify-items-start">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ user.name }}
                    </h2>
                    <div class="mb-4 flex flex-row">
                        <div class="mr-10">게시물 4</div>
                        <div class="mr-10">팔로우 80</div>
                        <div class="mr-10">팔로우 72</div>
                    </div>
                    <div class="mb-4">성철박</div>
                    <div lass="mb-4">Ph.D. Majored in Computer Science. Specifically Database management system</div>
                </div>
            </div>


        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <post-list/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from '@/Pages/Instagram/PostList.vue'

    export default defineComponent({
        components: {
            AppLayout,
            PostList,
        },
        props : ['user'],
    })
</script>
