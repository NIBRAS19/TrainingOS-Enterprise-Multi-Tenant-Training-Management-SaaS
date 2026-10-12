import {createRouter,createWebHistory} from 'vue-router'
import AppLayout from '../layouts/AppLayout.vue'
import AuthLayout from '../layouts/AuthLayout.vue'
import PublicLayout from '../layouts/PublicLayout.vue'
const router=createRouter({history:createWebHistory(),routes:[
{path:'/',component:PublicLayout,children:[{path:'',redirect:'/auth/login'},{path:'verify-certificate/:number',component:()=>import('../pages/public/CertificateVerifyPage.vue')}]},
{path:'/auth',component:AuthLayout,children:[{path:'',redirect:'/auth/login'},{path:'login',component:()=>import('../pages/auth/LoginPage.vue')},{path:'register',component:()=>import('../pages/auth/RegisterPage.vue')},{path:'forgot-password',component:()=>import('../pages/auth/ForgotPasswordPage.vue')}]},
{path:'/app',component:AppLayout,children:[
{path:'',redirect:'/app/dashboard'},{path:'dashboard',component:()=>import('../pages/DashboardPage.vue')},
{path:'learners',component:()=>import('../pages/LearnersPage.vue')},{path:'learners/:id',component:()=>import('../pages/LearnerDetailPage.vue')},
{path:'trainers',component:()=>import('../pages/TrainersPage.vue')},{path:'courses',component:()=>import('../pages/CoursesPage.vue')},{path:'courses/create',component:()=>import('../pages/CourseCreatePage.vue')},{path:'courses/:id',component:()=>import('../pages/CourseDetailPage.vue')},
{path:'batches',component:()=>import('../pages/BatchesPage.vue')},{path:'batches/create',component:()=>import('../pages/BatchCreatePage.vue')},
{path:'calendar',component:()=>import('../pages/CalendarPage.vue')},{path:'attendance',component:()=>import('../pages/AttendancePage.vue')},{path:'assessments',component:()=>import('../pages/AssessmentsPage.vue')},{path:'certificates',component:()=>import('../pages/CertificatesPage.vue')},{path:'documents',component:()=>import('../pages/DocumentsPage.vue')},{path:'reports',component:()=>import('../pages/ReportsPage.vue')},{path:'analytics',component:()=>import('../pages/AnalyticsPage.vue')},{path:'team',component:()=>import('../pages/TeamPage.vue')},{path:'notifications',component:()=>import('../pages/NotificationsPage.vue')},{path:'settings',component:()=>import('../pages/SettingsPage.vue')}
]}]})
export default router
