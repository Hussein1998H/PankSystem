import './login.css'
import Header from '../Header/Header';
import Foteer from '../foteer/Foteer';
import {useState } from 'react';
import  Loading  from '../Loading/Loading';
import Swal from 'sweetalert2'
import Cookie from 'universal-cookie';
import axios from 'axios'
import {useNavigate} from 'react-router-dom' 
const LoginForm = () => {
  const [email , setEmail] = useState('')
  const [password , setPassword] = useState('')
  const [id , setId] = useState('')
  const [loading , setLoading] = useState(false)
  const nav=useNavigate()
  function emailSet(e){
    setEmail(e.currentTarget.value);
  }
  function passSet(e){
    setPassword(e.currentTarget.value)
  }
  function idSet(e){
    setId(e.currentTarget.value)
  }
  async function send(e){
    e.preventDefault();
    if(email!=='' && password>=8 && id>=11){
      setLoading(true)
     try{
      let res = await  axios.post('http://127.0.0.1:8000/api/login',{
        email:email,
        password:password,
        ID_number:id,
      },)
      setLoading(false)
      const cookie = new Cookie()
      cookie.set('bearer',res.data.token)
      await  Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'تم تسجيل دخولك بنجاح',
        showConfirmButton: false,
        timer: 1500
      })
      if(res.data.data.role==='user'){
        nav('/employeeDashboard')
      }
      if(res.data.data.role==='customer'){
        nav('/customerDashbaord')
      }
      if(res.data.data.role==='admin'){
        nav('/adminDashboard')
      }
     }catch(err){
      setLoading(false)
        Swal.fire({
          icon: 'error',
          title: 'حدث خطأ ما',
          text: 'تعذر تسجيل الدخول تأكد من صحة معلوماتك',
          // footer: '<a href="">Why do I have this issue?</a>'
        })
        console.log(err)
     }
    }
  }
  return (
    <>
    <Header />
    {loading && <Loading />}
    <div className='login'>
      {/* <img className='img-login' src={login} alt='' /> */}
      <div className='img-login'></div>
     <form className='login-form' onSubmit={send}>
       <div className='form-controller'>
        <i className='fa-solid fa-envelope'></i>
        <div className='flx'>
        <input id='email' type='email' placeholder='البريد الإلكتروني' value={email} onChange={emailSet} required/>
        <label htmlFor='email' >البريد الإلكتروني</label>
        </div>
        </div>
        <div className='form-controller'>
        <i className='fa-solid fa-lock'></i>
        <div className='flx'>
        <input type='password' placeholder='كلمة المرور' minLength='8' value={password} onChange={passSet} required/>
        <label htmlFor="password">كلمة المرور</label>
        </div >
        </div>
        <div className='form-controller'>
        <i className='fa-solid fa-key'></i>
        <div className='flx'>
        <input type='password' placeholder='الرقم الوطني' minLength='11' value={id} onChange={idSet} required/>
        <label>الرقم الوطني</label>
        </div>
        </div>
        <button type='submit' className='login-btn'>تسجيل الدخول</button>
    </form>
    </div>
    <Foteer />
    </>
  )
}

export default LoginForm