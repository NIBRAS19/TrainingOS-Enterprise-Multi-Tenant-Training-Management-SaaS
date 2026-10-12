<template><div class="empty-state"><div class="empty-icon">{{ icon }}</div><h3>{{ title }}</h3><p>{{ description }}</p><div><slot></slot></div></div></template>
<script setup lang="ts">withDefaults(defineProps<{icon?:string;title:string;description:string}>(),{icon:'⌁'})</script>
