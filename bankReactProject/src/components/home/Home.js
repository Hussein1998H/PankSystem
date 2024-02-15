import { useEffect , useState} from 'react';
import imagesData from './imagesData';
import Header from '../Header/Header';
import Foteer from '../foteer/Foteer';
import './home.css'
const Home = () => {
  const [currentState , setCurrentState] = useState(0);
  useEffect(()=>{
    const timer = setTimeout(() => {
      if(currentState===8){
        setCurrentState(0);
      }else{
        setCurrentState(currentState+1);
      }
    }, 5000);
    return ()=> clearTimeout(timer);
  },[currentState])
  const titleStyle={
    'color':'#fff',
    'position':'absolute',
    'zIndex':'1000',
    'top':'40%',
    'left':'50%',
    'transform':'translate(-50%,-50%)',
    'fontSize':'40px',
    'textAlign':'center',
    'transition':'0.3s'
  }
  return (
    <>
    <header><Header /></header>
    <div>
         <div className='home-container'>
       <div className='mask'></div>
       <div className='home' style={{'backgroundImage':`url(${imagesData[currentState].url})`}}>
          <div className='container'>
                <h1 style={titleStyle}>{imagesData[currentState].text}</h1>
          </div>
        </div>
    </div>
    </div>
    <Foteer />
    </>
  )
}
export default Home;


