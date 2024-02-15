import { useState , useEffect } from "react"
import axios from "axios"
import  Cookie  from "universal-cookie"
import Skeleton from 'react-loading-skeleton'
import 'react-loading-skeleton/dist/skeleton.css'
const AccountsInfo = () => {
    const [accountInfo , setAccountInfo] = useState([])
    const [skeleton , setSkeleton] = useState(false)
    const cookie = new Cookie()
    const token = cookie.get('bearer')

    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/accounts',{
            headers:{
                Authorization : "Bearer " + token
            }
        }).then((res)=>setAccountInfo(res.data.data))
        .then(()=>setSkeleton(true))
        //eslint-disable-next-line react-hooks/exhaustive-deps
    },[])
    const tr = accountInfo.map((item , index)=>{
        return <tr key={index}>
            <td>{item.customer.firstName}</td>
            <td>{item.customer.lastName}</td>
            <td>{item.customer.ID_number}</td>
            <td>{item.branch.address}</td>
            <td>{item.accountNumber}</td>
            <td>{item.accmonies[0].balance.toFixed(2)}</td>
            <td>{item.accmonies[1].balance.toFixed(2)}</td>
            <td>{item.accmonies[2].balance.toFixed(2)}</td>
            <td>{item.type}</td>
            <td>{item.openingDate}</td>
        </tr>
    })
   
  return (
    <>
    {skeleton ? ( <table dir='rtl' className="account-info" style={{top:'450px'}}>
        <thead >
            <tr>
                <th>اسم العميل</th>
                <th>الكنية</th>
                <th>الرقم الوطني</th>
                <th>الفرع</th>
                <th>رقم الحساب</th>
                <th>الرصيد بالدولار</th>
                <th>الرصيد بالليرة التركية</th>
                <th>الرصيد باليورو</th>
                <th>نوع الحساب</th>
                <th>تاريخ التسجيل</th>
            </tr>
        </thead>
        <tbody>
        {accountInfo.length===0 ? <tr>
                <td style={{'transform':'translateX(-250%)'}}>لا يوجد حسابات</td>
                </tr>:(tr)}
        </tbody>
    </table>)
        :
        (<>
            <Skeleton style={{'width':'75%','height':'60px','transform':'translate(12.5%,230px)'}} />
            <Skeleton count={5} style={{'width':'75%','transform':'translate(12.5%,240px)'}} />
            </>)}
    </>
  )
}

export default AccountsInfo
