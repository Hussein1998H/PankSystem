import { useEffect, useState } from "react"
import axios from "axios"
import  Cookie  from "universal-cookie"
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'
const HTransaction = () => {

    const [costumers , setCostumers] = useState([])
    const [skeleton , setSkeleton] = useState(false)
    const cookie = new Cookie()
    const token = cookie.get('bearer')
    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/myTramsaction',{
            headers:{
                Authorization: 'Bearer '+token
            }
        }).then(res => setCostumers(res.data.data))
        .then(()=>setSkeleton(true))
        //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])
    let tr = costumers.map((item,index)=>{
        return<tr key={index}>
        <td>{index + 1}</td>
        <td>{item.FromCustomer}</td>
        <td>{item.AccountNumberFrom}</td>
        <td>{item.ToCustomer}</td>
        <td>{item.AccountNumberTo}</td>
        <td>{item.balance}</td>
        <td>{item.description}</td>
        <td>{item.trans_date}</td>
        </tr>
       })
  return (
    <>
    {skeleton ? ( <table dir='rtl' style={{top:"35%",maginButtom:"15px"}}>
        <thead >
            <tr>
                <th>  المعرف</th>
                <th>  المرسل</th>
                <th> رقم الحساب</th>
                <th>المستقبل</th>
                <th> رقم الحساب</th>
                <th>القيمة</th>
                <th>ملاحظات</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            {costumers.length===0 ? <tr>
                <td style={{'transform':'translateX(-350%)'}}>لا يوجد تحويلات</td>
            </tr>:(tr)}
        </tbody>
    </table>):(<>
            <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,150px)'}} />
            <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,160px)'}} />
            </>)}
</>
  )
}

export default HTransaction