const API_BASE=import.meta.env.VITE_API_URL||'/api/v1'
export async function api<T>(path:string,options:RequestInit={}):Promise<T>{
 const response=await fetch(`${API_BASE}${path}`,{headers:{'Content-Type':'application/json',...(options.headers||{})},credentials:'include',...options})
 if(!response.ok) throw new Error((await response.text())||`Request failed: ${response.status}`)
 return response.json() as Promise<T>
}
export const endpoints={auth:{me:'/auth/me',login:'/auth/login',logout:'/auth/logout'},learners:'/learners',trainers:'/trainers',courses:'/courses',batches:'/batches',certificates:'/certificates',reports:'/reports'}
