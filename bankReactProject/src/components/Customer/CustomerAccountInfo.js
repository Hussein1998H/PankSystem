import { useState , useEffect } from "react"
import axios from 'axios'
import  Cookie  from "universal-cookie";
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'
const CustomerAccountInfo = () => {
    const [account , setAccount] = useState([])
    const [skeleton , setSkeleton] = useState(false)
    const cookie = new Cookie()
    const token = cookie.get('bearer')
    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/showmyaccunt',{
            headers:{
                Authorization : 'Bearer ' + token
            }
        }).then((res)=>setAccount(res.data.data))
        .then(()=>setSkeleton(true))
         //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])
    
    // let tr = account.map((item,index)=>{
    //     return<tr key={index}>
    //     <td>{item.accountNumber}</td>
    //     <td>{item.type}</td>
    //     <td>{item.branch.address}</td>
    //    { item.accmonies.forEach(element => {
    //     <td>{element.balance}</td>
    //    })}
    //     </tr>
    //    })
    
       let tr = account.map((item,index)=>{
        return<tr key={index}>
              <td>{item.accountNumber}</td>
              <td>{item.type}</td>
              <td>{item.branch.address}</td>
              <td>{item.accmonies[0].balance.toFixed(2)}</td>
              <td>{item.accmonies[1].balance.toFixed(2)}</td>
              <td>{item.accmonies[2].balance.toFixed(2)}</td>
              <td>{item.openingDate}</td>
              {/* You can add more rows here for additional attributes */}
        </tr>
       })
  return (
    <>
    {skeleton ? (<table dir='rtl'>
        <thead >
            <tr>
                <th>رقم الحساب</th>
                <th>نوع الحساب</th>
                <th>الفرع</th>
                <th>الرصيد بالدولار</th>
                <th>الرصيد بالليرة التركية</th>
                <th>الرصيد باليورو</th>
                <th> تاريخ الافتتاح</th>
            </tr>
        </thead>
        <tbody>
        {account.length===0 ? <tr>
                <td style={{'transform':'translateX(-350%)'}}>لا يوجد حسابات</td>
            </tr>:(tr)}
        </tbody>
    </table>):(<>
            <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,230px)'}} />
            <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,240px)'}} />
            </>)}
    
    </>
  )
}

export default CustomerAccountInfo
