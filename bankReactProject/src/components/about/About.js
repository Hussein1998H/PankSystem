import './about.css';
import Card from './Card';
import data from './DataAbout'
import Header from '../Header/Header';
import BoxItem from './BoxItem';
import Foteer from '../foteer/Foteer';
import { useState , useEffect } from 'react';
import axios from 'axios';
const About = () => {
  const [report , setReport] = useState([])
  useEffect(()=>{
    axios('http://127.0.0.1:8000/api/reportCount')
    .then((res)=>setReport(res.data))
  },[])


  const aboutData = [
    {
        classIcon : 'icon-one',
        iconName : 'fa fa-users',
        itemNumber : report.CustomerCount
    },
    {
        classIcon : 'icon-two',
        iconName : 'fa fa-building',
        itemNumber : report.BranchCount
    },
    {
        classIcon : 'icon-three',
        iconName : 'fa fa-id-card',
        itemNumber : report.AccountsCount
    },
    {
        classIcon : 'icon-four',
        iconName : 'fa-solid fa-users-gear',
        itemNumber : report.EmployeeCount
    }
];

  let card=data.map((item , index)=>{
    return <Card key={index} img={item.img} name={item.name} text={item.role}/> 
  })
  let box = aboutData.map((item , index)=>{
    return <BoxItem key={index} clsname={item.classIcon} iconname={item.iconName}
    itemNumber={item.itemNumber}
     />
  }) 
  return (
    <>
    <header><Header /></header>
    <div className='about'>
        <div className='container'>
        <h2 className='about-logo'>حول الصفحة</h2>
        <div className='cards'>{card}</div>
            <div className='box'>
              {box}
            </div>
        </div>
    </div>
    <Foteer />
    </>
  )
}

export default About
