import{Outlet , Navigate} from 'react-router-dom'
import Cookie from 'universal-cookie'
export default function EmployeeRequireAuth(){
    const cookie = new Cookie()
    const token = cookie.get('bearer') 
    return token ? <Outlet /> : <Navigate to='/login' />
}
