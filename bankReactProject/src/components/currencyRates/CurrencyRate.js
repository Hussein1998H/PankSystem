import { useEffect, useState } from "react"
import Header from "../Header/Header"
import axios from "axios"
import './currency.css'
const CurrencyRate = () => {
  const [currency , setCurrency] = useState([])
  const [toDolar , setToDolar] = useState(0)
  const [toTRy , setToTRy] = useState(0)
  const [toEuro , setToEuro] = useState(0)
  const [eurusd , toEurUsd] = useState(0)
  function dolar(e){
    parseInt(setToDolar(e.currentTarget.value))
  }
  function toTry(e){
    setToTRy(e.currentTarget.value)
  }
  function euro(e){
    setToEuro(e.currentTarget.value)
  }
  function eurUsd(e){
    toEurUsd(e.currentTarget.value)
  }
  useEffect(()=>{
    axios.get('https://api.currencyfreaks.com/v2.0/rates/latest?apikey=a86036bc9c274a789a9ba344fe0c36cb&symbols=TRY,LBP,AED,IQD,JOD,MAD,TND,EGP,DZD,BHD,SAR,QAR,CNY,JPY,GBP,KWD,EUR')
    .then((res)=>setCurrency(res.data.rates))
  },[])
  const currencyData = [
    {
      imaage : require('../Assets/images/flags/aed.png'),
      sembol : 'AED',
      name : 'درهم إماراتي',
      price : Math.floor(currency.AED*100)/100
    },
    {
      imaage: require('../Assets/images/flags/qatar.png'),
      sembol : 'QAR',
      name : 'ريال قطري',
      price : Math.floor(currency.QAR*100)/100
    },
    {
      imaage: require('../Assets/images/flags/euro.png'),
      sembol : 'EUR',
      name : 'يورو',
      price : Math.floor(currency.EUR*100)/100
    },
    {
      imaage: require('../Assets/images/flags/sad.png'),
      sembol : 'SAR',
      name : 'ريال سعودي',
      price : Math.floor(currency.SAR*100)/100
    },
    {
      imaage: require('../Assets/images/flags/tunus.png'),
      sembol : 'TND',
      name : 'دينار تونسي',
      price : Math.floor(currency.TND*100)/100
    },
    {
      imaage: require('../Assets/images/flags/eygpt.png'),
      sembol : 'EGP',
      name : 'جنيه مصري',
      price : Math.floor(currency.EGP*100)/100
    },
    {
      imaage: require('../Assets/images/flags/cezayer.png'),
      sembol : 'DZD',
      name : 'دينار جزائري',
      price : Math.floor(currency.DZD*100)/100
    },
    {
      imaage: require('../Assets/images/flags/china.png'),
      sembol : 'CNY',
      name : 'يوان صيني',
      price : Math.floor(currency.CNY*100)/100
    },
    {
      imaage: require('../Assets/images/flags/fas.png'),
      sembol : 'MAD',
      name : 'درهم مغربي',
      price : Math.floor(currency.MAD*100)/100
    },
    {
      imaage: require('../Assets/images/flags/japon.png'),
      sembol : 'JPY',
      name : 'ين ياباني',
      price : Math.floor(currency.JPY*100)/100
    },
    {
      imaage: require('../Assets/images/flags/uak.png'),
      sembol : 'GBP',
      name : 'جنيه استرليني',
      price : Math.floor(currency.GBP*100)/100
    },
    {
      imaage: require('../Assets/images/flags/quit.png'),
      sembol : 'KWD',
      name : 'دينار كويتي',
      price : Math.floor(currency.KWD*100)/100
    },
    {
      imaage: require('../Assets/images/flags/turkiye.png'),
      sembol : 'TRY',
      name : 'ليرة تركية',
      price : Math.floor(currency.TRY*100)/100
    },
    {
      imaage: require('../Assets/images/flags/lebanon.png'),
      sembol : 'LBP',
      name : 'ليرة لبنانية',
      price : Math.floor(currency.LBP*100)/100
    },
    {
      imaage: require('../Assets/images/flags/iraq.png'),
      sembol : 'IQD',
      name : 'دينار عراقي',
      price : Math.floor(currency.IQD*100)/100
    },
    {
      imaage: require('../Assets/images/flags/jordon.png'),
      sembol : 'JOD',
      name : 'دينار أردني',
      price : Math.floor(currency.JOD*100)/100
    },
    {
      imaage: require('../Assets/images/flags/bahren.png'),
      sembol : 'BHD',
      name : 'دينار بحريني',
      price : Math.floor(currency.BHD*100)/100
    },
  ]
  const tr = currencyData.map((item , index)=>{
    return <tr key={index}>
      <td><img src={item.imaage}
      style={{'width':'50px','height':'50px','borderRadius':'25px'}} alt="" /></td>
      <td>{item.sembol}</td>
      <td>{item.name}</td>
      <td>{item.price}</td>
    </tr>
  })
  return (
    <>
    <header><Header /></header>
    <div style={{'height':'2000px'}}>
       <table dir='rtl' style={{'position':'absolute','top':'80%','left':'50%','transform':'translate(-50%,-32%)'}}>
            <thead >
                <tr>
                    <th>رمز البلد</th>
                    <th>رمز العملة</th>
                    <th>اسم العملة</th>
                    <th>قيمة العملة</th>
                </tr>
            </thead>
            <tbody>
              {tr}
            </tbody>
        </table>
        </div>
        <form style={{'position':'absolute','left':'50%','transform':'translate(-50%,1300px)'}}>
          <h3 style={{'textAlign':'center','color':'#f00'}}>دولار تركي</h3>
          <div className="form-currency">
            <input type="text" placeholder="القيمة بالدولار" onChange={dolar} />
            <div className="currency-icn">
            <i className="fa-solid fa-arrows-rotate"></i>
            </div>
            <input type="text" value={
             (Math.floor(currency.TRY*100)/100)*toDolar
              }/>
          </div>
        </form>
        <form style={{'position':'absolute','left':'50%','transform':'translate(-50%,1450px)'}}>
        <h3 style={{'textAlign':'center','color':'#f00'}}>تركي دولار</h3>
          <div className="form-currency">
          <input type="text" placeholder="القيمة بالليرة التركية" onChange={toTry} />
          <div className="currency-icn">
            <i className="fa-solid fa-arrows-rotate"></i>
            </div>
          <input type="text" value={
            Math.floor((toTRy/(Math.floor(currency.TRY*100)/100))*100)/100
          }/>
          </div>
        </form>
        <form style={{'position':'absolute','left':'50%','transform':'translate(-50%,1600px)'}}>
        <h3 style={{'textAlign':'center','color':'#f00'}}>يورو دولار</h3>
          <div className="form-currency">
          <input type="text" placeholder="القيمة باليورو" onChange={euro} />
          <div className="currency-icn">
            <i className="fa-solid fa-arrows-rotate"></i>
            </div>
          <input type="text" value={
            Math.floor((toEuro/(Math.floor(currency.EUR*100)/100))*100)/100
          }/>
          </div>
        </form>
        <form style={{'position':'absolute','left':'50%','transform':'translate(-50%,1750px)'}}>
        <h3 style={{'textAlign':'center','color':'#f00'}}>دولار يورو</h3>
          <div className="form-currency">
          <input type="text" placeholder="القيمة بالدولار" onChange={eurUsd} />
          <div className="currency-icn">
            <i className="fa-solid fa-arrows-rotate"></i>
            </div>
          <input type="text" value={
            Math.floor((eurusd*(Math.floor(currency.EUR*100)/100))*100)/100
          }/>
          </div>
        </form>
    </>
  )
}

export default CurrencyRate