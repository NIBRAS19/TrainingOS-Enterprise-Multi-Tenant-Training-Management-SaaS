<template><RouterLink to="/app/dashboard" class="logo"><span class="logo-mark">T</span><span v-if="!collapsed" class="logo-text">Training<span>OS</span></span></RouterLink></template>
<script setup lang="ts">defineProps<{collapsed?:boolean}>()</script>
