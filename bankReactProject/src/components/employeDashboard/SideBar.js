import img from '../Assets/images/logo copy.png'
import './sidestyle.css';
import Cookie from 'universal-cookie';
import axios from 'axios';
import Swal from 'sweetalert2'
import {useNavigate} from 'react-router-dom' 
import { useState } from 'react';
import Loading from '../Loading/Loading';
const SideBar = (props) => {

  const [loading , setLoading] =useState(false)
  const cookie = new Cookie()
  const nav = useNavigate()
  let token = cookie.get('bearer')

  function openSideBar(){
    const sideBar = document.querySelector('.side-bar');
    sideBar.classList.toggle('open-side');
  }
  
 async function logout(){ 
  setLoading(true)
  try{
    await axios.post('http://127.0.0.1:8000/api/logout',null,{
      headers:{
        Authorization: "Bearer " + token,
      },
    })
    await cookie.remove('bearer')
    setLoading(false)
    await  Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'تم تسجيل الخروج بنجاح',
      showConfirmButton: false,
      timer: 1500
    })
    nav('/')
  }catch(err){
    console.log(err)
  }
  }
  return (
    <>
    {loading && <Loading />}
    <nav className='container'>
      <div className="side-logo ">
          <img className="img-side" src={img} alt=""/>
          <h1 className='person-name'>{props.name} {props.last}</h1>
        </div>
        <button className='logout-btn' onClick={logout}>
        تسجيل الخروج
        <i className='fa-solid fa-arrow-right-from-bracket'></i>
      </button>
      </nav>
    <div className="side-bar">
      <i className="fa-solid fa-bars-staggered" onClick={openSideBar}></i>
      <ul className="ul-bar">
      {props.children}
      
      </ul>
    </div>
    </>
  )
}

export default SideBar