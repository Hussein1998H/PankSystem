import axios from 'axios'
import { useEffect, useState } from 'react'
import Loading from '../../Loading/Loading'
import Cookie  from 'universal-cookie'
import { Link} from 'react-router-dom'
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'
const EmpShow = () => {
    const [users , setUsers] = useState([])
    const [run , setRun] = useState(0)
    const [loading , setLoading] = useState(false)
    const [currentUser , setCurrentUser] = useState([])
    const [skeleton , setSkeleton] = useState(false)
    const cookie = new Cookie()
    const token = cookie.get('bearer')
    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/user/profile',{
            headers:{
              Authorization : 'Bearer ' + token
            }
          }).then((res)=>setCurrentUser(res.data.data))
          //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])

    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/user/index',{
            headers:{
                Authorization: 'Bearer '+token
            }
        }).then(res => setUsers(res.data.data))
        .then(()=>setSkeleton(true))
        //eslint-disable-next-line react-hooks/exhaustive-deps
    },[run])
//    let user = Array.from(users) 
    const userFilter = users.filter((user)=>user.id!==currentUser.id)
   let tr = userFilter.map((item,index)=>{
    return<tr key={index}>
    <td>{index + 1}</td>
    <td>{item.firstName}</td>
    <td>{item.lastName}</td>
    <td>{item.role}</td>
    <td>{item.email}</td>
    <td>
    <i className="fa-solid fa-trash" style={{'color':'#11101D','padding':'0px 10px','cursor':'pointer'}} onClick={()=>delet(item.id)}></i>
    <Link to={`${item.id}`}>
    <i className="fa-solid fa-pen" style={{'color':'#f00','cursor':'pointer'}}></i>
    </Link>
    </td>
    </tr>
   })
   async function delet(id) {
       setLoading(true)
       try{
           await axios.delete(`http://127.0.0.1:8000/api/user/destroy/${id}`,{
               headers:{
                   Authorization : 'Bearer '+token
               }
           })
           setRun( (prev)=> prev + 1)
           setLoading(false)
       }catch(err){
           console.log(err)
           setLoading(false)
       }
   }
  return (
    <>
        {loading && <Loading />}
        {skeleton ? (   <table dir='rtl'>
            <thead >
                <tr>
                    <th>رقم الموظف</th>
                    <th>اسم الموظف</th>
                    <th>الكنية</th>
                    <th>المسمى الوظيفي</th>
                    <th>البريد الإلكتروني</th>
                    <th>المهمة</th>
                </tr>
            </thead>
            <tbody>
                {userFilter.length===0 ? <tr>
                <td style={{'transform':'translateX(-250%)'}}>لا يوجد مستخدمين</td>
                </tr>:(tr)}
            </tbody>
        </table>):
        (<>
        <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,130px)'}} />
        <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,140px)'}} />
        </>)}
        
    </>
  )
}

export default EmpShow