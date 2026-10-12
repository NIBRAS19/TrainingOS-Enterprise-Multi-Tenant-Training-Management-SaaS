<template><div class="page-header"><div><div class="breadcrumbs"><RouterLink to="/app/dashboard">Overview</RouterLink><span>/</span><span>{{ title }}</span></div><h1>{{ title }}</h1><p v-if="description">{{ description }}</p></div><div class="page-actions"><slot name="actions"></slot></div></div></template>
<script setup lang="ts">defineProps<{title:string;description?:string}>()</script>
