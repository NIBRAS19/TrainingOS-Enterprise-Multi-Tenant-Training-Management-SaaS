import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { notifications as initialNotifications } from '../data/mock'
export const useAppStore=defineStore('app',()=>{
 const sidebarCollapsed=ref(false),mobileNavOpen=ref(false),searchOpen=ref(false)
 const notifications=ref(initialNotifications),currentOrg=ref('Nexa Training Academy')
 const user=ref({name:'Nibras',email:'nibras@trainingos.demo',role:'Owner',initials:'N'})
 const unreadCount=computed(()=>notifications.value.filter(n=>n.unread).length)
 function toggleSidebar(){sidebarCollapsed.value=!sidebarCollapsed.value}
 function toggleMobileNav(){mobileNavOpen.value=!mobileNavOpen.value}
 function markRead(id:number){const i=notifications.value.find(n=>n.id===id);if(i)i.unread=false}
 function markAllRead(){notifications.value.forEach(n=>n.unread=false)}
 return {sidebarCollapsed,mobileNavOpen,searchOpen,notifications,currentOrg,user,unreadCount,toggleSidebar,toggleMobileNav,markRead,markAllRead}
})
