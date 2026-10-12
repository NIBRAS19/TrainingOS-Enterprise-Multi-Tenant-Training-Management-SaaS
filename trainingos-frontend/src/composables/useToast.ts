import { ref } from 'vue'
type Toast={id:number;type:'success'|'error'|'info';message:string}
const toasts=ref<Toast[]>([]);let id=0
export function useToast(){const push=(message:string,type:Toast['type']='success')=>{const toast={id:++id,type,message};toasts.value.push(toast);window.setTimeout(()=>{toasts.value=toasts.value.filter(t=>t.id!==toast.id)},3200)};return {toasts,push}}
