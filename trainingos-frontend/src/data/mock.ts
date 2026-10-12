import type { Batch, Certificate, Course, Learner, NotificationItem, Trainer } from '../types'
export const learners:Learner[]=[
{id:1,name:'Sara Ahmed',email:'sara@example.com',company:'Nexa Group',course:'Laravel Fundamentals',attendance:92,status:'active',avatar:'SA'},
{id:2,name:'Omar Ali',email:'omar@example.com',company:'Vertex Labs',course:'Python for APIs',attendance:87,status:'active',avatar:'OA'},
{id:3,name:'Fatima Noor',email:'fatima@example.com',company:'Orbit Consulting',course:'Application Security',attendance:98,status:'active',avatar:'FN'},
{id:4,name:'Ali Hassan',email:'ali@example.com',company:'Gulf Systems',course:'Vue 3 & TypeScript',attendance:78,status:'active',avatar:'AH'},
{id:5,name:'Maya Thomas',email:'maya@example.com',company:'Bluewave',course:'Laravel Fundamentals',attendance:94,status:'active',avatar:'MT'},
{id:6,name:'Yusuf Khan',email:'yusuf@example.com',company:'Nova Solutions',course:'DevSecOps Essentials',attendance:83,status:'inactive',avatar:'YK'}]
export const trainers:Trainer[]=[
{id:1,name:'Ahmed Khan',email:'ahmed@trainingos.demo',specialty:'Backend Engineering',courses:6,batches:4,status:'active'},
{id:2,name:'Mariam Ali',email:'mariam@trainingos.demo',specialty:'Application Security',courses:4,batches:3,status:'active'},
{id:3,name:'Daniel Joseph',email:'daniel@trainingos.demo',specialty:'Cloud & DevOps',courses:5,batches:2,status:'active'}]
export const courses:Course[]=[
{id:1,name:'Laravel Fundamentals',code:'LAR-101',category:'Development',duration:24,modules:8,learners:124,completion:87,status:'active'},
{id:2,name:'Python for APIs',code:'PY-204',category:'Development',duration:20,modules:7,learners:88,completion:79,status:'active'},
{id:3,name:'Application Security',code:'SEC-302',category:'Security',duration:16,modules:6,learners:64,completion:92,status:'active'},
{id:4,name:'Vue 3 & TypeScript',code:'VUE-220',category:'Frontend',duration:18,modules:7,learners:58,completion:81,status:'draft'},
{id:5,name:'DevSecOps Essentials',code:'DSO-401',category:'Cloud',duration:18,modules:6,learners:42,completion:73,status:'active'}]
export const batches:Batch[]=[
{id:1,name:'Laravel Fundamentals — Sep A',code:'2026-09-A',course:'Laravel Fundamentals',trainer:'Ahmed Khan',start:'2026-09-15',end:'2026-09-30',learners:32,capacity:36,status:'active'},
{id:2,name:'Python for APIs — Sep B',code:'2026-09-B',course:'Python for APIs',trainer:'Ahmed Khan',start:'2026-09-20',end:'2026-10-03',learners:24,capacity:30,status:'planned'},
{id:3,name:'Application Security — Aug',code:'2026-08-C',course:'Application Security',trainer:'Mariam Ali',start:'2026-08-05',end:'2026-08-19',learners:28,capacity:30,status:'completed'},
{id:4,name:'DevSecOps Essentials — Sep',code:'2026-09-D',course:'DevSecOps Essentials',trainer:'Daniel Joseph',start:'2026-09-22',end:'2026-10-06',learners:18,capacity:24,status:'planned'}]
export const certificates:Certificate[]=[
{id:1,number:'TRN-2026-000184',learner:'Sara Ahmed',course:'Laravel Fundamentals',issued:'2026-09-18',status:'issued'},
{id:2,number:'TRN-2026-000179',learner:'Fatima Noor',course:'Application Security',issued:'2026-09-16',status:'issued'},
{id:3,number:'TRN-2026-000177',learner:'Maya Thomas',course:'Laravel Fundamentals',issued:'2026-09-14',status:'pending'},
{id:4,number:'TRN-2026-000162',learner:'Yusuf Khan',course:'DevSecOps Essentials',issued:'2026-09-02',status:'revoked'}]
export const notifications:NotificationItem[]=[
{id:1,title:'Certificate ready',description:'Sara Ahmed completed Laravel Fundamentals.',time:'8 min ago',unread:true},
{id:2,title:'Tomorrow’s session',description:'Laravel Fundamentals starts at 10:00 AM.',time:'1 hr ago',unread:true},
{id:3,title:'Batch almost full',description:'Laravel Fundamentals — Sep A is at 89% capacity.',time:'3 hrs ago',unread:false}]
