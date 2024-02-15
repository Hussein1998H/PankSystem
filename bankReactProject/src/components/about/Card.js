import './about.css';
const Card = (props) => {
  return (
   <div className='card'>
        <div className='card-img' style={{'backgroundImage':`url("${props.img}")`,}}></div>
        <h2 className='card-h2' >{props.name}</h2>
        <h3 className='card-h3' >{props.text}</h3>
   </div>
  )
}

export default Card