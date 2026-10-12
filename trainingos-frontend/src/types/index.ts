export type Status = 'active' | 'draft' | 'completed' | 'cancelled' | 'pending' | 'issued' | 'revoked' | 'planned'
export interface Learner { id:number; name:string; email:string; company:string; course:string; attendance:number; status:'active'|'inactive'; avatar:string }
export interface Trainer { id:number; name:string; email:string; specialty:string; courses:number; batches:number; status:'active'|'inactive' }
export interface Course { id:number; name:string; code:string; category:string; duration:number; modules:number; learners:number; completion:number; status:Status }
export interface Batch { id:number; name:string; code:string; course:string; trainer:string; start:string; end:string; learners:number; capacity:number; status:Status }
export interface Certificate { id:number; number:string; learner:string; course:string; issued:string; status:'issued'|'pending'|'revoked' }
export interface NotificationItem { id:number; title:string; description:string; time:string; unread:boolean }
