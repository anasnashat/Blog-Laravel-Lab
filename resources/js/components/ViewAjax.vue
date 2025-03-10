<script setup>
import { ref, defineProps } from 'vue';
import axios from 'axios';

// Define props
const props = defineProps({
    id: {
        type: Number,
        required: true
    }
});

const isModalOpen = ref(false);
const post = ref(null);

// Fetch post details when modal opens
const fetchPostDetails = async () => {
    if (!props.id) return;
    try {
        const response = await axios.get(`/api/posts/${props.id}`);
        post.value = response.data;
        isModalOpen.value = true;
    } catch (error) {
        console.error("Error fetching the post!", error);
    }
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>

<template>
    <div class="inline-block">
        <!-- View Details Button -->
        <button @click="fetchPostDetails" 
                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 transition-colors">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            View
        </button>

        <!-- Modal -->
        <div v-if="isModalOpen" 
             class="fixed inset-0 flex items-center justify-center z-50"
             @click.self="closeModal">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-[400px] transform transition-all animate-modal-enter">
                <!-- Header with close button -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 v-if="post" class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-1">
                        {{ post.title }}
                    </h2>
                    <button @click="closeModal" 
                            class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4 space-y-4">
                    <div v-if="post" class="prose dark:prose-invert max-w-none">
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ post.description }}</p>
                    </div>

                    <!-- Author info -->
                    <div v-if="post?.user" class="flex items-center space-x-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ post.user.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ post.user.email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg border-t border-gray-200 dark:border-gray-700">
                    <button @click="closeModal" 
                            class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-modal-enter {
    animation: modal-enter 0.2s ease-out;
}

@keyframes modal-enter {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
</style>
