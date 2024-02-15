import './header.css'
import './Li'
import Li from './Li';
import './PrimaryButton'
import PrimaryButton from './PrimaryButton';
import  Cookie  from 'universal-cookie';
const Header = () => {
  const cookie = new Cookie()
  const token = cookie.get('bearer')
  let loginPage = true;
  if(window.location.pathname==='/login'){
    loginPage=false;
  }
    const listInfo=[['القائمة الرئيسية','/'],['حول الصفحة','/about'],['خدماتنا','/service'],['اسعار الصرف','/currencyRates'],['إتصل بنا','/contactUs']]
    const li=listInfo.map((item , index)=><Li key={index} name={item[0]} class='list-item' linkpath={item[1]} classLink='link-item'/>)
    function toggler(){
     let ul =document.querySelector('.nav-list');
     ul.classList.toggle('active');
    }
  return (
    <div className='main-nav'>
         <nav className='navbar container'>
      <h1 className='logo' style={{'color':'#fff'}}><span style={{'color':'#f00'}}>Sham</span>Bank</h1>
        <ul className='nav-list' dir='rtl'>
            {li}
        </ul>
        {loginPage && !token && <PrimaryButton icn='fa-solid fa-lock' name="تسجيل الدخول" />}
        <button className='toggler' onClick={toggler}>
        <i className="fa fa-bars" aria-hidden="true"></i>
        </button>
    </nav>
    </div>
  )
}

export default Header