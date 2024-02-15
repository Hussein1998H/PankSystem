import Header from "../Header/Header"
const CantactUs = () => {
  return (
    <>
      <Header />
      <form style={{'transform':'translate(110px,50px)'}}>
        <div className='form-controller'>
        <input type="text" placeholder="الإسم"  minLength='3' required />
        </div>
        <div className='form-controller'>
        <input type="text" placeholder="الكنية" minLength='3' required />
        </div>
      <div className='form-controller'>
        <div className='flx'>
        <input id='email' type='email' placeholder='البريد الإلكتروني' required />
        </div>
        </div>
        <div className='form-controller'>
          <input type="text" placeholder="اكتب ما تريد" style={{'height':'100px'}} minLength='3' required />
        </div>
        <button type='submit' className='login-btn' style={{'transform':'translateX(30px)'}}>إرسال</button>
      </form>
    </>
  )
}

export default CantactUs
