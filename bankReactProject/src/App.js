import { useEffect, useState } from 'react'
import {Route , Routes} from 'react-router-dom'
import {Home , About , Serveces , LoginForm , EmployeDash ,
        UserAdd , UpdateUser , AdminDashboard , Loading ,
         Customer , CreateUserAdmin, AdminRequireAuth ,
         EmployeeRequireAuth , EmpShow , CurrencyRate , 
         CreateBranch , UpdateUserAdmin , CostumerShow ,
         AllCustomer , CreatAccount , AccountManage ,
         DepositMony , ShowBranches , MonyTransfer ,
         AccountsInfo , PersonelDetails ,  CustomerAccountInfo ,
        UpdateBranch , WithdrawMony , Transhistory ,
        Transfer , HTransaction , CustomerRequireAuth , RequireBack ,
        CantactUs } 
    from './components/import.js' 
const App = ()=>{
  const [loading , setLoading] = useState(false);
  useEffect(()=>{
    setLoading(true)
    setTimeout(()=>{
      setLoading(false)
    },2000)
  },[])
  return(
    <>
    {
      loading?
      <Loading />
      :
      <Routes>
      <Route path='/' element={<Home />} />
      <Route path='about' element={<About />} />
      <Route path='service' element={<Serveces />} />
      <Route path='currencyRates' element={<CurrencyRate />} />
      <Route path='contactUs' element={<CantactUs />} />
      <Route element={<RequireBack />}>
      <Route path='login' element={<LoginForm />} />
      </Route>
      <Route element={<EmployeeRequireAuth />}>
      <Route path='employeeDashboard' element={<EmployeDash />}>
          <Route path='userAdd' element={<UserAdd />}/>
          <Route path='usersmanage' element={<AllCustomer />} />
          <Route path="usersmanage/:id" element={<UpdateUser />} />
          <Route path='accountmanage' element={<AccountManage />}>
            <Route path='createAccount' element={<CreatAccount />} />
            <Route path='accountsInfo' element={<AccountsInfo /> } />
            <Route path='depositMoney' element={<DepositMony />}/>
            <Route path='widthDraw' element={<WithdrawMony />} />
          </Route>
          <Route path='transhistory' element={<Transhistory />} />
          <Route path='branchesShow' element={<ShowBranches />} />
          <Route path='monyTransfer' element={<MonyTransfer />} />
      </Route>
      </Route>
      <Route element={<AdminRequireAuth />}>
      <Route path='adminDashboard' element={<AdminDashboard />}>
        <Route path='CreateUser' element={<CreateUserAdmin />} />
        <Route path='employeesShow' element={<EmpShow />} />
        <Route path="employeesShow/:id" element={<UpdateUserAdmin />} />
        <Route path='createbranch' element={<CreateBranch />} />
        <Route path='createbranch/:id' element={<UpdateBranch />} />
        <Route path='usersShow' element={<CostumerShow />} />
      </Route>
      </Route>
      <Route path='load' element={<Loading />} />
      <Route path='form' element={<LoginForm />} />
      <Route element={<CustomerRequireAuth />}>
      <Route path='customerDashbaord' element={<Customer />}>
        <Route path='customerProfile' element={<PersonelDetails />} />
        <Route path='customerTransiction' element={<MonyTransfer />} />
        <Route path='myAccountInfo' element={<CustomerAccountInfo />} />
        <Route path='transfer' element={<Transfer />} />
        <Route path='historyTransiction' element={<HTransaction />} />
      </Route>
      </Route>
    </Routes>
    }
    </>
    
  )
}
export default App;
