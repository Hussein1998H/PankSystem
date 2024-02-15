import React, { useState ,useEffect} from 'react'
import axios from 'axios';
import Cookie from 'universal-cookie';
import Swal from 'sweetalert2'
import  Loading from '../Loading/Loading';
const Transfer = () => {



  const cookie = new Cookie()
  const token = cookie.get('bearer')

  
  const[account,setaccount]=useState([])
  const[accountNumberFrom,setaccountNumberFrom]=useState('');
  const[typemony,settypemony]=useState('USD');
  const[description,setdescription]=useState('');
  const[typeto,settypeto]=useState('USD');
  const[amount,setamount]=useState('');
  const [loading , setLoading] = useState(false)


  function MonyFrom(e){
      settypemony(e.currentTarget.value)
    }
  function MonyTO(e){
      settypeto(e.currentTarget.value)
    }

    function Account(e){
      setaccountNumberFrom(e.currentTarget.value)
    }


  async function Submit(e) { 
  let Flage=true
  e.preventDefault();

  setLoading(true);
  if (amount==='') {
      Flage=false
  }
  else{
      Flage=true;
  }
  if(Flage){

try{
 await axios.post('http://127.0.0.1:8000/api/convertMony',
{
 accountNumberFrom:accountNumberFrom,
 typemony:typemony,
 typeto:typeto,
 amount:amount,
 description:description

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
  text: 'تعذر إجراء المناقلة ',
})
console.log(err)
}
 
}
  }
  useEffect(()=>{
    axios.get('http://127.0.0.1:8000/api/showmyaccunt',{
        headers:{
            Authorization: 'Bearer '+token
        }
    }).then(res => setaccount(res.data.data))
    //eslint-disable-next-line react-hooks/exhaustive-deps
  },[])


  return (
    <div>

<>
{loading && <Loading />}
<form onSubmit={Submit} style={{padding:'15px'}} >

      <div style={{textAlign:'center',backgroundColor:'red', color:'white'}}> 
      <h3 >تحويل المال  من عملة الى أخرى</h3>

      </div>
      <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'end'}}>

     
      <select onChange={Account} style={{width:'100%'}}>
        <option label='أختر حساب'></option>
        {
            account.map((items)=>(
              // console.log(items.address)
              <option key={items.id} value={items.accountNumber} >
                {items.accountNumber}
            </option>
            ))
           }
        </select>
       
      </div>

      <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'end'}}>
      <select onChange={MonyTO} style={{width:'24%'}}>
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
        <label htmlFor="exampleInputID23" style={{marginLeft:'1rem'}}>نوع المال الذي تريد التحويل له </label>


     {/* <input type=" number" placeholder="رقم حساب المستقبل "
       required
      value={accountNumberTo}
      onChange={(e)=>setaccountNumberTo(e.target.value)} /> */}

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
        <label htmlFor="exampleInputID23" style={{marginLeft:'1rem'}}>نوع المال الذي تريد التحويل منه </label>

    {/* <label htmlFor="exampleInputID23" className="form-label text-danger">نوع المال المرسل</label> */} 
      </div>

      <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'space-between'}}>
      <input type="text" placeholder=" ملاحظات" 
      value={description}
      onChange={(e)=>setdescription(e.target.value)}
      />
      <input type="number" placeholder="القيمة"    
      required
      value={amount}
      onChange={(e)=>setamount(e.target.value)}
      /> 

      </div>



      <div style={{width:'50%' ,display:'flex',alignItems:'center',justifyContent:'start'}}>
      <button type='submit' className='login-btn' style={{'transform':'translateX(120px)'}}>إرسال</button>

      </div>
    </form>



</>

    </div>
  )
}

export default Transfer