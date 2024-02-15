import React, { useState,useEffect } from 'react'
import axios from 'axios';
import Cookie from 'universal-cookie';
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'

const ShowBranches = () => {
    const cookie = new Cookie()
    const token = cookie.get('bearer')

    const [branches , setBranches] = useState([])
    const [skeleton , setSkeleton] = useState(false)
    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/branches',{
            headers:{
                Authorization: 'Bearer '+token
            }
        }).then(res => setBranches(res.data.data))
        .then(()=>setSkeleton(true))
        //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])

    let branch = branches.map((item,index)=>{
        return<tr key={index}>
        <td>{item.id}</td>
        <td>{item.address}</td>
        <td>{item.phone}</td>
        </tr>
       })

  return (
    <>
    {skeleton ? (
         <table dir='rtl'>
         <thead >
             <tr>
                 <th>رقم الفرع</th>
                 <th>عنوان الفرع</th>
                 <th>رقم الهاتف</th>
             </tr>
         </thead>
         <tbody>
             {branch}          
         </tbody>
     </table>
    ) :
         (<>
            <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,130px)'}} />
            <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,140px)'}} />
            </>)}
       
    </>
  )
}

export default ShowBranches
