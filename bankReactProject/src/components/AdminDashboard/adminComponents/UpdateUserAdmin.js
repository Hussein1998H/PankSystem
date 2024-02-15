import { useEffect, useState } from 'react'
import Loading from '../../Loading/Loading'
import Swal from 'sweetalert2'
import axios from 'axios'
import Cookie from 'universal-cookie';
import { useNavigate } from 'react-router';
const UpdateUserAdmin = () => {
  const cookie = new Cookie()
  const token = cookie.get('bearer')
  const nav = useNavigate()

  const [firstname , setFirstname] = useState('')
  const [lastname , setLastname] = useState('')
  const [branch , setBranch] = useState('edlib')
  const [adrress , setAdrress] = useState('')
  const [id , setID] = useState('')
  const [gender , setGender] = useState('ذكر')
  const [phone , setPhone] = useState('')
  const [email , setEmail] = useState('')
  const [pssword , setPssword] = useState('')
  const [loading , setLoading] = useState(false)
  const [role , setRole] = useState('admin')
  const[barnchdata,setbarnchdata]=useState([])
  function firstName(e){
    setFirstname(e.currentTarget.value)
  }
  function lastName(e){
    setLastname(e.currentTarget.value)
  }
  function Branch(e){
    setBranch(e.currentTarget.value)
  }
  function Adrress(e){
    setAdrress(e.currentTarget.value)
  }
  function Id(e){
    setID(e.currentTarget.value)
  }
  function Phone(e){
    setPhone(e.currentTarget.value)
  }
  function Email(e){
    setEmail(e.currentTarget.value)
  }
  function Gender(e){
    setGender(e.currentTarget.value)
  }
  function Password(e){
    setPssword(e.currentTarget.value)
  }
  function roleFunc(e) {
    setRole(e.currentTarget.value)
  }
  const idUser = window.location.pathname.split('/').slice(-1)[0];
  useEffect(()=>{
    axios.get(`http://127.0.0.1:8000/api/user/edit/${idUser}`,{
      headers:{
        Authorization : 'Bearer ' + token
      }
    }).then((res)=>{
      setFirstname(res.data.data.firstName)
      setLastname(res.data.data.lastName)
      setAdrress(res.data.data.address)
      setID(res.data.data.ID_number)
      setEmail(res.data.data.email)
      setPhone(res.data.data.phone)
    })
     //eslint-disable-next-line react-hooks/exhaustive-deps
  },[])
  useEffect(()=>{
    axios.get('http://127.0.0.1:8000/api/branches',{
        headers:{
            Authorization: 'Bearer '+token
        }
    }).then(res => setbarnchdata(res.data.data))
    //eslint-disable-next-line react-hooks/exhaustive-deps
},[])
  async function update(e) {
    e.preventDefault();
    if(pssword.length>=8 || pssword.length===0){
      setLoading(true)
      try{
        await axios.post(`http://127.0.0.1:8000/api/user/update/${idUser}?_method=PATCH`,{
          firstName:firstname,
          lastName:lastname,
          gender:gender,
          address:adrress,
          email:email,
          phone:phone,
          password:pssword,
          branchaddress:branch,
          ID_number:id,
          role:role
        },{
          headers:{
            Authorization : 'Bearer ' + token
          }
        })
        setLoading(false)
        await Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'تم تعديل الموظف بنجاح',
          showConfirmButton: false,
          timer: 1500
        })
        nav('/adminDashboard/employeesShow')
      }catch(err){
        setLoading(false)
        Swal.fire({
          icon: 'error',
          title: 'حدث خطأ ما',
          text: 'تعذر تعديل الموظف',
        })
        console.log(err)
      }
    }
    else{
      Swal.fire({
        icon: 'error',
        title: 'حدث خطأ ما',
        text: 'تعذر إضافة الموظف تأكد من صحة معلوماتك',
      })
    }
  }
  return (
    <div>
    {loading && <Loading />}
      <form onSubmit={update}>
    <div className="form-item">
      <input type="text" placeholder="الكنية" value={lastname} onChange={lastName} />
      <input type="text" placeholder="الإسم" value={firstname} onChange={firstName} />
      <select onChange={Branch}>
      {
            barnchdata.map((items)=>(
              // console.log(items.address)
              <option key={items.id} value={items.address} >
                {items.address}
            </option>
            ))
           }
      </select>
    </div>
    <div className="form-item">
      <input type="text" placeholder="العنوان" value={adrress} onChange={Adrress} />
      <input type="text" placeholder="الرقم الوطني" value={id} onChange={Id} />
      <select onChange={Gender}>
     
          <option value="ذكر">
             ذكر  
          </option>
          <option value="أنثى">
          أنثى
          </option>
        </select>
    </div>
    <div className="form-item">
      <input type="text" placeholder="رقم الهاتف" value={phone} onChange={Phone} />  
      <input type="email" placeholder="البريد الإلكتروني" value={email} onChange={Email} />
      <input type="password" placeholder="كلمة المرور" value={pssword} onChange={Password} />
      <select onChange={roleFunc}>
          <option>admin</option>
          <option>user</option>
        </select>
    </div>
    <button type='submit' className='login-btn' style={{'transform':'translateX(150px)'}}>تعديل</button>
  </form>
  </div>
  )
}

export default UpdateUserAdmin
