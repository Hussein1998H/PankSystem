import { useEffect, useState } from 'react'
import SideBar from '../employeDashboard/SideBar'
import customerData from './custumerData'
import LiSideBar from "../employeDashboard/LiSideBar";
import axios from 'axios'
import  Cookie  from "universal-cookie";
import { Outlet } from 'react-router-dom';
import './customer.css'
const Customer = () => {
  const [profile , setProfile] = useState([])
  const cookie = new Cookie()
  const token = cookie.get('bearer')
  useEffect(()=>{
    axios.get('http://127.0.0.1:8000/api/customer/profile',{
      headers:{
        Authorization : 'Bearer ' + token
      }
    }).then((res)=>setProfile(res.data.data))
     //eslint-disable-next-line react-hooks/exhaustive-deps
  },[])

  const li = customerData.map((item , index)=>{
    return <LiSideBar key={index} path={item.path} name={item.name} icon={item.icon} />
  })
  return (
    <>
    <SideBar name={profile.firstName} last={profile.lastName}>
      {li}
    </SideBar>
    <Outlet />
    </>
  )
}

export default Customer