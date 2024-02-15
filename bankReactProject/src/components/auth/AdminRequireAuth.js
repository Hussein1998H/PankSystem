import Cookie from "universal-cookie";
import {Outlet , Navigate} from 'react-router-dom'
export default function AdminRequireAuth(){
    const cookie = new Cookie()
    const token = cookie.get('bearer')
   return token ? <Outlet />: <Navigate to='/login' />
}
