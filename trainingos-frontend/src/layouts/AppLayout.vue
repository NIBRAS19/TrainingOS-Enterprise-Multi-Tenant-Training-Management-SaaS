<template>
<div class="app-shell" :class="{collapsed:store.sidebarCollapsed}">
  <aside class="sidebar" :class="{open:store.mobileNavOpen}">
    <div class="sidebar-top"><AppLogo :collapsed="store.sidebarCollapsed"/><button class="collapse-btn" @click="store.toggleSidebar">‹</button></div>
    <div class="org-switch"><div class="org-avatar">N</div><div v-if="!store.sidebarCollapsed"><strong>{{store.currentOrg}}</strong><span>Organization</span></div><span v-if="!store.sidebarCollapsed" class="chevron">⌄</span></div>
    <nav class="side-nav">
      <div class="nav-label" v-if="!store.sidebarCollapsed">Overview</div><RouterLink to="/app/dashboard"><span>⌂</span><em v-if="!store.sidebarCollapsed">Dashboard</em></RouterLink>
      <div class="nav-label" v-if="!store.sidebarCollapsed">Management</div>
      <RouterLink to="/app/learners"><span>◌</span><em v-if="!store.sidebarCollapsed">Learners</em></RouterLink>
      <RouterLink to="/app/trainers"><span>♧</span><em v-if="!store.sidebarCollapsed">Trainers</em></RouterLink>
      <RouterLink to="/app/courses"><span>▦</span><em v-if="!store.sidebarCollapsed">Courses</em></RouterLink>
      <RouterLink to="/app/batches"><span>▤</span><em v-if="!store.sidebarCollapsed">Batches</em></RouterLink>
      <RouterLink to="/app/calendar"><span>◫</span><em v-if="!store.sidebarCollapsed">Calendar</em></RouterLink>
      <div class="nav-label" v-if="!store.sidebarCollapsed">Training</div>
      <RouterLink to="/app/attendance"><span>✓</span><em v-if="!store.sidebarCollapsed">Attendance</em></RouterLink>
      <RouterLink to="/app/assessments"><span>◉</span><em v-if="!store.sidebarCollapsed">Assessments</em></RouterLink>
      <RouterLink to="/app/certificates"><span>▱</span><em v-if="!store.sidebarCollapsed">Certificates</em></RouterLink>
      <RouterLink to="/app/documents"><span>□</span><em v-if="!store.sidebarCollapsed">Documents</em></RouterLink>
      <div class="nav-label" v-if="!store.sidebarCollapsed">Reporting</div>
      <RouterLink to="/app/reports"><span>▥</span><em v-if="!store.sidebarCollapsed">Reports</em></RouterLink>
      <RouterLink to="/app/analytics"><span>⌁</span><em v-if="!store.sidebarCollapsed">Analytics</em></RouterLink>
      <div class="nav-label" v-if="!store.sidebarCollapsed">Organization</div>
      <RouterLink to="/app/team"><span>♙</span><em v-if="!store.sidebarCollapsed">Team</em></RouterLink>
      <RouterLink to="/app/settings"><span>⚙</span><em v-if="!store.sidebarCollapsed">Settings</em></RouterLink>
    </nav>
    <div class="sidebar-bottom"><RouterLink to="/app/notifications" class="mini-link"><span>🔔</span><em v-if="!store.sidebarCollapsed">Notifications</em><b v-if="store.unreadCount && !store.sidebarCollapsed">{{store.unreadCount}}</b></RouterLink><div class="profile-mini"><Avatar :name="store.user.name" size="sm"/><div v-if="!store.sidebarCollapsed"><strong>{{store.user.name}}</strong><span>{{store.user.role}}</span></div></div></div>
  </aside>
  <div v-if="store.mobileNavOpen" class="mobile-overlay" @click="store.toggleMobileNav"></div>
  <section class="main-shell">
    <header class="topbar"><button class="icon-btn mobile-only" @click="store.toggleMobileNav">☰</button><button class="search-trigger" @click="store.searchOpen=true"><span>⌕</span><span>Search anything...</span><kbd>⌘ K</kbd></button><div class="topbar-actions"><RouterLink to="/app/notifications" class="icon-btn badge-btn">🔔<b v-if="store.unreadCount">{{store.unreadCount}}</b></RouterLink><div class="top-profile"><Avatar :name="store.user.name" size="sm"/><div><strong>{{store.user.name}}</strong><span>{{store.currentOrg}}</span></div></div></div></header>
    <main class="main-content"><RouterView/><ToastHost/></main>
  </section>
  <Modal :open="store.searchOpen" title="Global search" description="Find learners, courses, batches and certificates" size="lg" @close="store.searchOpen=false"><input class="search-big" placeholder="Try “Laravel”, “Sara”, “certificate”…" autofocus/><div class="search-suggestions"><RouterLink to="/app/learners" @click="store.searchOpen=false">◌ Search learners</RouterLink><RouterLink to="/app/courses" @click="store.searchOpen=false">▦ Search courses</RouterLink><RouterLink to="/app/batches" @click="store.searchOpen=false">▤ Search batches</RouterLink></div></Modal>
</div>
</template>
<script setup lang="ts">import AppLogo from '../components/AppLogo.vue';import Avatar from '../components/Avatar.vue';import Modal from '../components/Modal.vue';import ToastHost from '../components/ToastHost.vue';import {useAppStore} from '../stores/app';const store=useAppStore()</script>
