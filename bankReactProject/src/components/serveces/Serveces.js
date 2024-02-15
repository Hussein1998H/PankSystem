import './serveces.css';
import CardServices from './CardServices';
import dataService from './DataService';
import Header from '../Header/Header';
import Foteer from '../foteer/Foteer';
const Serveces = () => {
    let ser = dataService.map((item , index)=>{
       return <CardServices key={index} img={item.img} title={item.title} des={item.des} />
      // return <Card key={index} img={item.img} name={item.title} text={item.des}/> 
    });
  return (
    <>
    <header><Header /></header>
    <div className='service'>
      <div className='container'>
        <div className='service-cards'>
            {ser}
        </div>
      </div>
    </div>
    <Foteer />
    </>
  )
}

export default Serveces