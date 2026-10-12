<template><div class="avatar" :class="size" :title="name"><img v-if="src" :src="src" :alt="name"/><span v-else>{{ initials }}</span></div></template>
<script setup lang="ts">import {computed} from 'vue';const props=defineProps<{name:string;src?:string;size?:'sm'|'md'|'lg'}>();const initials=computed(()=>props.name.split(' ').map(v=>v[0]).slice(0,2).join('').toUpperCase())</script>
