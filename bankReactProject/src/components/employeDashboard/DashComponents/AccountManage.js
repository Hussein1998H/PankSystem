import { Link,Outlet } from "react-router-dom"
const AccountManage = () => {
  return (
    <>
      <nav className='account-nav'>
          <ul className='account-ul'>
              <li className='account-li'><Link to='createAccount' className='account-link'>إنشاء حساب</Link></li>
              <li className='account-li'>|</li>
              <li className='account-li'><Link to='accountsInfo' className='account-link'>معلومات الحسابات</Link></li>
              <li className='account-li'>|</li>
              <li className='account-li'><Link to='depositMoney' className='account-link'>إيداع رصيد</Link></li>
              <li className='account-li'>|</li>
              <li className='account-li'><Link to='widthDraw' className='account-link'>سحب رصيد</Link></li>
          </ul>
      </nav>
      <Outlet />
    </>
  )
}

export default AccountManage
