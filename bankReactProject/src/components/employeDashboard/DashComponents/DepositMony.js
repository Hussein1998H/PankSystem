import React, { useState } from 'react'
import axios from 'axios';
import Cookie from 'universal-cookie';
import Swal from 'sweetalert2'
import { Loading } from '../../import';

const DepositMony = () => {

  const cookie = new Cookie()
  const token = cookie.get('bearer')

    const[accountNumber,setaccountNumber]=useState('');
    const[typemony,settypemony]=useState('USD');
    const[amount,setamount]=useState('');
    const [loading , setLoading] = useState(false)


    function MonyFrom(e){
        settypemony(e.currentTarget.value)
      }



    async function Submit(e) { 
    let Flage=true
    e.preventDefault();

    setLoading(true);
    if (accountNumber===''||amount==='' ) {
        Flage=false
    }
    else{
        Flage=true;
    }
    if(Flage){

try{
  await axios.post('http://127.0.0.1:8000/api/deposit',
  {
    accountNumber:accountNumber,
   typemony:typemony,
   amount:amount,

  },{
   headers:{
     Authorization : 'Bearer ' + token
   }
 }
  )
  // .then((response)=>console.log(response));


  setLoading(false)
  await Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'تم إجراء المناقلة  بنجاح',
    showConfirmButton: false,
    timer: 1500
  })
} catch(err){
  setLoading(false)
  Swal.fire({
    icon: 'error',
    title: 'حدث خطأ ما',
    text: 'تعذر إيداع المال',
  })
  console.log(err)
}
   
    }
    
}

  return (
    <>
    {loading && <Loading />}
   <form onSubmit={Submit} style={{'marginTop':'50px','marginLeft':'70px'}} >

      <div style={{textAlign:'center',backgroundColor:'red', color:'white'}}> 
      <h3 >إيداع المال للحساب</h3>

      </div>
      <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'space-between'}}>

      <select onChange={MonyFrom} style={{width:'24%'}}>
      <option value="USD">
     USD
       </option>
     <option value='TRY'>
       TRY
       </option>
      <option value='EUR'>
      EUR
   </option>
        </select>
        <label htmlFor="exampleInputID23" style={{marginLeft:'1rem'}}>نوع المال </label>



     <input type="number" placeholder="رقم الحساب  " 
     required
     value={accountNumber}
     onChange={(e)=>setaccountNumber(e.target.value)}
     />

  

       
      </div>



      <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'center'}}>

      <input type="number" placeholder="القيمة"    
      required
      value={amount}
      onChange={(e)=>setamount(e.target.value)}
     style={{width:'100%'}}
      /> 

      </div>



      <div style={{width:'50%' ,display:'flex',alignItems:'center',justifyContent:'start'}}>
      <button type='submit' className='login-btn' style={{'transform':'translateX(120px)'}}>إرسال</button>

      </div>
    </form>


    </>
  )
}

export default DepositMony