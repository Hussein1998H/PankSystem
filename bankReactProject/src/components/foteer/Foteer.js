import { useEffect, useState } from 'react'
import './foteer.css'
import axios from 'axios'

const Foteer = () => {
  const [branch , setBranch] = useState([])
  useEffect(()=>{
    axios.get('http://127.0.0.1:8000/api/allbranches')
    .then((res)=>setBranch(res.data.data))
  },[])
  return (
    <footer>
        <div className='container'>
        <div className='adresses'>
          <div className='footer-flex'>
          <i className="fa-solid fa-house"></i>
          <h2 style={{'textAlign':'right'}}>العناوين الرئيسة</h2>
          </div>
            {/* <p>إدلب-جانب القصر العدلي</p>
            <p>أريحا-الطريق العام</p>
            <p>جسر الشغور-جانب البريد</p>
            <p>سرمدا-الساحة العامة</p> */}
            {
              branch.map((item , index)=>{
                return <p key={index} style={{'textAlign':'center'}}>{item.address}</p>
              })
            }
        </div>

        <div className='phones'>
          <div className='footer-flex'>
          <i className="fa-solid fa-phone"></i>
          <h2 style={{'textAlign':'center'}}>ارقام الهواتف</h2>
          </div>
            {/* <p>0090 531 123 4567</p>
            <p>0090 532 234 5678</p>
            <p>0090 533 345 6789</p>
            <p>0090 534 456 7890</p> */}
            {
              branch.map((item , index)=>{
                return <p key={index}>{item.phone}</p>
              })
            }
          </div>
{/* 
        <div className='emails'>
          <div className='footer-flex'>
          <i className="fa-solid fa-envelope"></i>
          <h2 style={{'textAlign':'center'}}>عناوين البريد</h2>
          </div>
          <p>brunch1@gmail.com</p>
          <p>brunch2@gmail.com</p>
          <p>brunch3@gmail.com</p>
          <p>brunch4@gmail.com</p>
        </div> */}
     
        </div>
    </footer>
  )
}

export default Foteer