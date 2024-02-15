import axios from 'axios'
import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import Loading from '../../Loading/Loading'
import Cookie  from 'universal-cookie'
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'
const CreateBranch = () => {
  const [branches , setBranches] = useState([])
  const [run , setRun] = useState(0)
  const cookie = new Cookie()
  const [loading , setLoading] = useState(false)
  const token = cookie.get('bearer')
  const [address , setAddress] = useState('')
  const [branchPhone , setBranchPhone] = useState('')
  const [skeleton , setSkeleton] = useState(false)
  const getAllBranches = async()=>{
    await axios.get('http://127.0.0.1:8000/api/branches',{
      headers:{
          Authorization: 'Bearer '+token
      }
  }).then(res => setBranches(res.data.data))
  .then(()=>setSkeleton(true))
  }

  useEffect(()=>{
    getAllBranches()
    //eslint-disable-next-line react-hooks/exhaustive-deps
},[run])
  let branch = branches.map((item,index)=>{
    return<tr key={index}>
    <td>{item.id}</td>
    <td>{item.address}</td>
    <td>{item.phone}</td>
    <td>
    <i className="fa-solid fa-trash" style={{'color':'#11101D','padding':'0px 10px','cursor':'pointer'}} onClick={()=>deletee(item.id)}></i>
    <Link to={`${item.id}`}>
    <i className="fa-solid fa-pen" style={{'color':'#f00','cursor':'pointer'}}></i>
    </Link>
    </td>
    </tr>
   })
   function addres(e) {
     setAddress(e.currentTarget.value)
   }
   function phne(e) {
     setBranchPhone(e.currentTarget.value)
   }
   async function createBranche(e) {
    e.preventDefault();
    if(address!=='' && branchPhone!==''){
      setLoading(true)
      try{
        await axios.post('http://127.0.0.1:8000/api/branches',{
          address:address,
          phone:branchPhone
        },{
          headers:{
            Authorization : 'Bearer ' + token
          }
        })
        setRun(prev => prev + 1)
        setLoading(false)
      }catch(err){
        console.log(err)
        setLoading(false)
      }
    }
   }
   async function deletee(id) {
    setLoading(true)
     try{
       await axios.delete(`http://127.0.0.1:8000/api/branches/${id}`,{
         headers:{
           Authorization : 'Bearer ' + token
         }
       })
       setRun((prev)=> prev+1)
       setLoading(false)
     }catch(err){
       console.log(err)
       setLoading(false)
     }
   }
  return (
       <>
        {loading && <Loading />}
        <div className='branch-flex'>
          {skeleton ? (<table dir='rtl'>
            <thead >
                <tr>
                    <th>رقم الفرع</th>
                    <th>عنوان الفرع</th>
                    <th>رقم الهاتف</th>
                    <th>المهمة</th>
                </tr>
            </thead>
            <tbody>
            {branches.length===0 ? <tr>
                <td style={{'transform':'translateX(-250%)'}}>لا يوجد أفرع</td>
                </tr>:(branch)}          
            </tbody>
        </table>)
          :
          (<>
            <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,130px)'}} />
            <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,140px)'}} />
            </>)}
          
        </div>
        <form className='brnch-form' onSubmit={createBranche}>
        <input className='branch' type='text' placeholder='عنوان الفرع' value={address} onChange={addres} />
        <input className='branch' type='text' placeholder='رقم الهاتف' value={branchPhone} onChange={phne} />
        <button type='submit' onSubmit={createBranche} className='branch-btn'>إضافة</button>
        </form>
       
    </>
  )
}

export default CreateBranch
