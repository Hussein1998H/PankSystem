import SideBar from "./SideBar"
import sideBarData from './sideBarData';
import LiSideBar from "./LiSideBar";
import {Outlet} from 'react-router-dom';
import './DashComponents/dashComponent.css'
import { useEffect , useState } from "react";
import  Cookie  from "universal-cookie";
import axios from "axios";
const EmployeDash = () => {
const li = sideBarData.map((item , index)=>{
  return <LiSideBar key={index} path={item.path} name={item.name} icon={item.icon} />
})
const [profile , setProfile] = useState([])
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
    <div className="dashbaord">
      <SideBar name={profile.firstName} last={profile.lastName}>
        {li}
      </SideBar>
      <Outlet />
    </div>
    
  )
}

export default EmployeDash