<template><div class="table-wrap"><table><thead><tr><th v-for="h in headers" :key="h">{{h}}</th><th v-if="actions"></th></tr></thead><tbody><slot></slot></tbody></table></div></template>
<script setup lang="ts">defineProps<{headers:string[];actions?:boolean}>()</script>
