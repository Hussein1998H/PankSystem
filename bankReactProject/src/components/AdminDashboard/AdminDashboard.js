import SideBar from '../employeDashboard/SideBar'
import LiSideBar from '../employeDashboard/LiSideBar'
import admin from './admin'
import {Outlet} from 'react-router-dom'
import { useEffect, useState } from 'react'
import axios from 'axios'
import Cookie from 'universal-cookie'
import './adminComponents/adminComponentStyle.css'
const AdminDashboard = () => {
    const liAdmin =admin.map((item , index)=>{
      return <LiSideBar key={index} path={item.path} name={item.name} icon={item.icon} />
    }) 
    const [profile , setProfile] = useState({})
    const cookie = new Cookie()
    const token = cookie.get('bearer')
    useEffect(()=>{
      axios.get('http://127.0.0.1:8000/api/user/profile',{
        headers:{
          Authorization : 'Bearer ' + token
        }
      }).then((res)=>setProfile(res.data.data))
      //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])
  return (
    <div>
        <SideBar name={profile.firstName} last={profile.lastName}>
            {liAdmin}
        </SideBar>
        <Outlet />
    </div>
  )
}
export default AdminDashboard;
