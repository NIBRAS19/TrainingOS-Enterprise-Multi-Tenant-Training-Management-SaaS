<template><span class="status-badge" :class="`status-${tone}`"><span class="status-dot"></span>{{ label || status }}</span></template>
<script setup lang="ts">
import {computed} from 'vue'
const props=defineProps<{status:string;label?:string}>()
const tone=computed(()=>['active','issued','completed'].includes(props.status)?'success':['pending','planned','draft'].includes(props.status)?'warning':['cancelled','revoked','inactive'].includes(props.status)?'danger':'neutral')
</script>
