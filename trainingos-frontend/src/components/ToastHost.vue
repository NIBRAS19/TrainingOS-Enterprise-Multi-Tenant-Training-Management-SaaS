<template><div class="toast-host"><TransitionGroup name="toast"><div v-for="toast in toasts" :key="toast.id" class="toast" :class="`toast-${toast.type}`"><span>{{ toast.type==='success'?'✓':toast.type==='error'?'!':'i' }}</span>{{ toast.message }}</div></TransitionGroup></div></template>
<script setup lang="ts">import {useToast} from '../composables/useToast';const {toasts}=useToast()</script>
