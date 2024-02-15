import axios from "axios"
import { useEffect, useState } from "react"
import Cookie from 'universal-cookie';
import Loading from '../../Loading/Loading'
import Swal from 'sweetalert2'
import { useNavigate } from 'react-router';
const UpdateBranch = () => {
    const [address ,setAddress] = useState('')
    const [phone , setPhone] = useState('')
    const cookie = new Cookie()
    const token = cookie.get('bearer')
    const nav = useNavigate()
    const [loading , setLoading] = useState(false)

    function addres(e){
        setAddress(e.currentTarget.value)
    }
    function phne(e){
        setPhone(e.currentTarget.value)
    }
    const idBranch = window.location.pathname.split('/').slice(-1)[0];
    useEffect(()=>{
        axios.get(`http://127.0.0.1:8000/api/branches/${idBranch}`,{
            headers:{
                Authorization : 'Bearer ' + token
            }
        }).then((res)=>{
            setAddress(res.data.data.address)
            setPhone(res.data.data.phone)
        })
        //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])
    async function updateBranch(e){
        e.preventDefault();
        if(address.length>0 && phone.length>0){
            setLoading(true)
            try{
                await axios.put(`http://127.0.0.1:8000/api/branches/${idBranch}`,{
                    address : address,
                    phone : phone
                },{
                    headers:{
                        Authorization : 'Bearer ' + token
                    }
                })
                setLoading(false)
                await Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'تم تعديل الفرع بنجاح',
                    showConfirmButton: false,
                    timer: 1500
                  })
                  nav('/adminDashboard/createbranch')
            }catch(err){
                setLoading(false)
                Swal.fire({
                  icon: 'error',
                  title: 'حدث خطأ ما',
                  text: 'تعذر تعديل الفرع',
                })
                console.log(err)
            }
        }
       
    }
  return (
    <>
    {loading && <Loading />}
    <form className='brnch-form' onSubmit={updateBranch} >
    <input style={{'textAlign':'center'}} className='branch' type='text' placeholder='عنوان الفرع' value={address} onChange={addres} />
    <input style={{'textAlign':'center'}} className='branch' type='text' placeholder='رقم الهاتف' value={phone} onChange={phne} />
    <button type='submit' className='branch-btn'>تعديل</button>
    </form>
    </>
  )
}

export default UpdateBranch
