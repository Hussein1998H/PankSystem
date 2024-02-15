import React from 'react'
import { Link } from 'react-router-dom'
const LiSideBar = (props) => {
    function clickedList(e){
        let listGroup = document.querySelectorAll('.list-group');
        let arrayGroup = Array.from(listGroup);
      arrayGroup.forEach((el)=>{
        el.classList.remove('active-side');
      })
      e.currentTarget.parentNode.parentNode.classList.add('active-side');
      }
  return (
     <div className="list-group" >
      <li className="side-item">
      <Link to={props.path} className='link' onClick={clickedList}>{props.name}</Link>
     </li>
     <i className={props.icon} style={{'padding':'0 15px'}}></i>
    </div>
  )
}

export default LiSideBar