import { useEffect, useState } from 'react'
import axios from 'axios'
import  Cookie  from "universal-cookie";
import user from '../Assets/images/user.png'
const PersonelDetails = () => {
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
  return (
    <div className="containerc">
      <div className='flex'>
        <h4>الإسم : {profile.firstName}</h4>
        <h4>الكنية : {profile.lastName}</h4>
        <h4>الرقم الوطني : {profile.ID_number}</h4>
        <h4>العنوان : {profile.address}</h4>
      </div>
      <div className='flex'>
        <img src={user} alt='' style={{'width':'100px','height':'100px','margin':'0 auto'}} />
        <h4>
        {profile.email}
        : البريد الإلكتروني
        </h4>
        <h4>رقم الهاتف : {profile.phone}</h4>
        <h4>الجنس : {profile.gender}</h4>
      </div>
      <div>

      </div>
    </div>
  )
}

export default PersonelDetails
