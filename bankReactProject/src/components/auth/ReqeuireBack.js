import Cookie from "universal-cookie";
import {Outlet} from 'react-router-dom'
export default function AdminRequireAuth(){
    const cookie = new Cookie()
    const token = cookie.get('bearer')
   return token ? window.history.back(): <Outlet /> ;
}
