<script setup>
import { ref } from "vue";
import ViewAjax from "./ViewAjax.vue";

let activeId = ref(2);

</script>

<template>
    <div>
        <view-ajax :id="activeId"></view-ajax>
    </div>
</template>

<style scoped>
h1 {
    color: #4a5568;
}
</style>
