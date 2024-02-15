import React, { useState,useEffect } from 'react'
import axios from 'axios';
import Cookie from 'universal-cookie';
import Swal from 'sweetalert2'
import { Loading } from '../../import';

const CreatAccount = () => {

    const cookie = new Cookie()
    const token = cookie.get('bearer')

    const[address,setaddress]=useState('edlib');
    const[ID_number,setID_number]=useState('');
    const[type_mony,settype_mony]=useState('USD');
    const[balance,setbalance]=useState('');
    const[AccountType,setAccountType]=useState('');
    const[barnchdata,setbarnchdata]=useState([])
    const [loading , setLoading] = useState(false)

    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/branches',{
            headers:{
                Authorization: 'Bearer '+token
            }
        }).then(res => setbarnchdata(res.data.data))
        //eslint-disable-next-line react-hooks/exhaustive-deps
      },[])

    function MonyType(e){
        settype_mony(e.currentTarget.value)
      }
      function Branch(e){
        setaddress(e.currentTarget.value)
      }

      async function Submit(e) { 
        let Flage=true
        e.preventDefault();
    
        setLoading(true);
        if (ID_number===''||balance===''||AccountType==='' ) {
            Flage=false
        }
        else{
            Flage=true;
        }
        if(Flage){
    
    try{
       await axios.post('http://127.0.0.1:8000/api/accounts',
      {
      address:address,
      ID_number:ID_number,
      type_mony:type_mony,
      balance:balance,
      AccountType:AccountType,
    
      },{
       headers:{
         Authorization : 'Bearer ' + token
       }
     }
      )
    
      setLoading(false)
      await Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'تم فتح الحساب بنجاح  بنجاح',
        showConfirmButton: false,
        timer: 1500
      })
    } catch(err){
      setLoading(false)
      Swal.fire({
        icon: 'error',
        title: 'حدث خطأ ما',
        text: 'تعذر إجراء فتح الحساب ',
      })
      console.log(err)
    }
       
        }
        
    }



  return (
    <>
    {loading && <Loading />}
    <form onSubmit={Submit} style={{'marginTop':'50px','marginLeft':'70px'}}>
    
          <div style={{textAlign:'center',backgroundColor:'red', color:'white'}}> 
          <h3 >   فتح حساب مصرفي جديد</h3>
    
          </div>
          <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'end'}}>
    
          <select onChange={Branch} style={{width:'30%'}}>
        {
            barnchdata.map((items)=>(
              // console.log(items.address)
              <option key={items.id} value={items.address} >
                {items.address}
            </option>
            ))
           }
        </select>
            <label htmlFor="exampleInputID23" style={{marginLeft:'2rem'}}> الفرع</label>
    
    
    
         <input type="number" placeholder="الرقم الوطني للزبون   " 
         required
         value={ID_number}
         onChange={(e)=>setID_number(e.target.value)}
         />
        {/* <label htmlFor="exampleInputID23" className="form-label text-danger">نوع المال المرسل</label> */}
    
      
    
           
          </div>
    
          <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'end'}}>
          <select onChange={MonyType} style={{width:'30%'}}>
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
            <label htmlFor="exampleInputID23" style={{marginLeft:'1rem'}}>نوع المال</label>
    
    
         <input type=" number" placeholder="قيمة مبدئية "
           required
          value={balance}
          onChange={(e)=>setbalance(e.target.value)} />
          </div>
    
          <div className="form-item"style={{width:'100%' ,display:'flex',alignItems:'center',justifyContent:'center'}}>
          <input type="text" placeholder=" نوع الحساب" 
          value={AccountType}
          onChange={(e)=>setAccountType(e.target.value)}
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

export default CreatAccount